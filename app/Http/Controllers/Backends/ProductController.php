<?php

namespace App\Http\Controllers\Backends;

use App\helpers\ImageManager;
use File;
use Exception;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Translation;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('product.view')) {
            abort(403, 'Unauthorized action.');
        }

        $products = Product::when($request->brand_id, function ($query) use ($request) {
                        $query->where('brand_id', $request->brand_id);
                    })
                    ->with('productgallery')
                    ->latest('id')
                    ->get();

        $product_instock = $products->map(function ($product) {
            $productInfo = $product->product_info;
            if (is_array($productInfo)) {
                $totalQty = array_sum(array_column($productInfo, 'product_qty'));
                $product->total_qty = $totalQty;
            }
            return $product;
        });

        $brands = Brand::all();
        if ($request->ajax()) {
            $view = view('backends.product._table', compact('products', 'brands', 'product_instock'))->render();
            return response()->json([
                'view' => $view
            ]);
        }

        return view('backends.product.index', compact('products', 'brands', 'product_instock'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('product.create')) {
            abort(403, 'Unauthorized action.');
        }

        $brands = Brand::all();
        $products = Product::with('brand')->get();

        return view('backends.product.create', compact('products', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('product.create')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'brand_id' => 'required',
        ]);

        if (is_null($request->name)) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'name',
                    'Name field is required!'
                );
            });
        }
        if (is_null($request->description)) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'description',
                    'description field is required!'
                );
            });
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            // dd($request->all());
            DB::beginTransaction();

            $pro = new Product;
            $pro->name = $request->name;
            $pro->description = $request->description;
            $pro->brand_id = $request->brand_id;
            $pro->rating = $request->rating;
            $pro->created_by = auth()->user()->id;
            $pro->new_arrival = $request->has('new-arrival') ? 1 : 0;
            $pro->recommended = $request->has('recommended') ? 1 : 0;
            $pro->popular = $request->has('popular') ? 1 : 0;

            $products_info = [];
            if ($request->products_info) {
                foreach ($request->products_info['product_size'] as $key => $number) {
                    $item['product_size'] = $number;
                    $item['product_price'] = number_format((float)$request->products_info['product_price'][$key], 2, '.', '');
                    $item['product_qty'] = $request->products_info['product_qty'][$key];
                    array_push($products_info, $item);
                }
                $pro->product_info =$products_info;
            }

            $pro->save();

            $productid = $pro->id;
            $product_gallery = new ProductGallery();
            $product_gallery->product_id = $productid;

            if ($request->filled('image_names')) {
                $imageDetails = json_decode($request->input('image_names'), true);
                $product_data = [];
                foreach ($imageDetails as $detail) {
                    $directory = public_path('uploads/products');
                    if (!\File::exists($directory)) {
                        \File::makeDirectory($directory, 0777, true);
                    }
                    $moved_image = \File::move(public_path('uploads/temp/' . $detail), $directory . '/' . $detail);
                    $product_data[] = $detail;
                    $product_gallery->images = $product_data;
                    $product_gallery->save();
                }
            }

            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Created successfully')
            ];
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }

        return redirect()->route('admin.product.index')->with($output);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $brands = Brand::all();
        $product = Product::withoutGlobalScopes()->with('brand', 'productgallery')->findOrFail($id);

        return view('backends.product.edit', compact('product', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('product.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'brand_id' => 'required',
            // 'images' => ['nullable', function ($attribute, $value, $fail) {
            //     $images = json_decode($value, true);
            //     if (is_array($images) && count($images) > 5) {
            //         $fail('You can upload a maximum of 5 images.');
            //     }
            // }],
        ]);

        if (is_null($request->name)) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'name',
                    'Name field is required!'
                );
            });
        }
        if (is_null($request->description)) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'description',
                    'description field is required!'
                );
            });
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->brand_id = $request->brand_id;
            $product->rating = $request->rating;
            $product->new_arrival = $request->has('new-arrival') ? 1 : 0;
            $product->recommended = $request->has('recommended') ? 1 : 0;
            $product->popular = $request->has('popular') ? 1 : 0;

            $products_info = [];
            if ($request->products_info) {
                foreach ($request->products_info['product_size'] as $key => $number) {
                    $item['product_size'] = $number;
                    $item['product_price'] = number_format((float)$request->products_info['product_price'][$key], 2, '.', '');
                    $item['product_qty'] = $request->products_info['product_qty'][$key];
                    array_push($products_info, $item);
                }
                $product->product_info =$products_info;
            }
            $product->save();

            $product_gallery = ProductGallery::where('product_id', $product->id)->first();
            $existingImages = $product_gallery->images ?? [];
            $imageNameToUpdate = $request->input('image_names');
            $newImages = json_decode($imageNameToUpdate, true);

            $product_data = [];
            if (is_array($newImages)) {
                foreach ($newImages as $image) {
                    $directory = public_path('uploads/products');
                    if (!\File::exists($directory)) {
                        \File::makeDirectory($directory, 0777, true);
                    }

                    $sourcePath = public_path('uploads/temp/' . $image);
                    $destinationPath = $directory . '/' . $image;

                    if (\File::exists($sourcePath)) {
                        \File::move($sourcePath, $destinationPath);
                        $product_data[] = $image;
                    }
                }
            }

            $mergedImages = array_merge($existingImages, $product_data);
            if ($product_gallery) {
                $product_gallery->images = $mergedImages;
                $product_gallery->save();
            } else {
                $product_gallery = new ProductGallery();
                $product_gallery->product_id = $product->id;
                $product_gallery->images = $mergedImages;
                $product_gallery->save();
            }


            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Created successfully')
            ];
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }

        return redirect()->route('admin.product.index')->with($output);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('product.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);
            $productImages = ProductGallery::where('product_id', $id)->get();

            foreach ($productImages as $image) {
                if ($image->images) {
                    foreach ($image->images as $img) {
                        $imagePath = public_path('uploads/products/' . $img);
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                }
                $image->delete();
            }
            $product->delete();

            $products = Product::latest('id')->get();
            $view = view('backends.product._table', compact('products'))->render();

            DB::commit();
            $output = [
                'success' => 1,
                'view'  => $view,
                'msg' => __('Deleted successfully')
            ];
        } catch (Exception $e) {
            DB::rollBack();

            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }

        return response()->json($output);
    }

    public function updateStatus(Request $request)
    {
        if (!auth()->user()->can('product.edit')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->id);
            $product->status = $product->status == 1 ? 0 : 1;
            $product->save();

            $output = ['status' => 1, 'msg' => __('Status updated')];

            DB::commit();
        } catch (Exception $e) {

            $output = ['status' => 0, 'msg' => __('Something went wrong')];
            DB::rollBack();
        }

        return response()->json($output);
    }

    public function uploadNewGallery(Request $request)
    {
        if (!auth()->user()->can('product.edit')) {
            abort(403, 'Unauthorized action.');
        }

        try{
            \Log::info($request->all());
            DB::beginTransaction();
            $product_gallery = ProductGallery::where('product_id', $request->product_id)->first();
            if (!$product_gallery) {
                $product_gallery = new ProductGallery();
                $product_gallery->product_id = $request->product_id;
                $product_gallery->images = [];
            }
            $productgallery = $product_gallery->images??[];

            if ($request->filled('image_names')) {
                $imageDetails = $request->input('image_names');
                $product_data = [];
                foreach ($imageDetails as $detail) {
                    $directory = public_path('uploads/products');
                    if (!\File::exists($directory)) {
                        \File::makeDirectory($directory, 0777, true);
                    }
                    $moved_image = \File::move(public_path('uploads/temp/' . $detail), $directory . '/' . $detail);
                    $product_data[] = $detail;
                }
                $merged = array_merge($productgallery, $product_data);
                $product_gallery->images = $merged;
            }
            $product_gallery->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => __('Created successfully'),
            ]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteProductGallery(Request $request)
    {
        if (!auth()->user()->can('product.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $productGallery = ProductGallery::where('product_id', $request->product_id)->first();
        if ($productGallery) {
            $imageNameToDelete = $request->input('name');
            $images = $productGallery->images;
            $imageExists = false;
            foreach ($images as $image) {
                if ($image === $imageNameToDelete) {
                    $imageExists = true;
                    break;
                }
            }
            if ($imageExists) {
                $newImages = array_filter($images, function ($image) use ($imageNameToDelete) {
                    return $image !== $imageNameToDelete;
                });
                $imagePath = public_path('uploads/products/' . $imageNameToDelete);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $productGallery->images = array_values($newImages);
                $productGallery->save();

                return response()->json(['success' => true]);
            }
        }
        return response()->json(['success' => false, 'message' => 'Image not found.']);
    }
}
