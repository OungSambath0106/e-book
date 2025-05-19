<?php

namespace App\Http\Controllers\Backends;

use App\helpers\ImageManager;
use File;
use Exception;
use App\Models\Product;
use App\Models\Translation;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Validator;
use Picqer\Barcode\BarcodeGeneratorHTML;

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

        $products = Product::when($request->category_id, function ($query) use ($request) {
                $query->whereHas('categories', function ($query) use ($request) {
                    $query->where('categories.id', $request->category_id);
                });
            })
            ->with('productgallery', 'categories')
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

        $categories = Category::all();
        if ($request->ajax()) {
            $view = view('backends.product._table', compact('products', 'categories', 'product_instock'))->render();
            return response()->json([
                'view' => $view
            ]);
        }

        return view('backends.product.index', compact('products', 'categories', 'product_instock'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('product.create')) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        $products = Product::with('categories')->get();
        $authors = Author::all();
        return view('backends.product.create', compact('products', 'categories', 'authors'));
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
            'categories' => 'required',
            'author_id' => 'required',
        ]);

        if (is_null($request->name)) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'name',
                    'Name field is required!'
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
            $pro->author_id = $request->author_id;
            $pro->rating = $request->rating;
            $pro->qty = $request->qty;
            $pro->price = $request->price;
            $pro->pages = $request->pages;
            $pro->reviews = $request->reviews;
            $pro->format = $request->format;
            $pro->barcode = $request->barcode;
            $pro->publish = $request->publish;
            $pro->created_by = auth()->user()->id;
            $pro->new_arrival = $request->has('new-arrival') ? 1 : 0;
            $pro->recommended = $request->has('recommended') ? 1 : 0;
            $pro->popular = $request->has('popular') ? 1 : 0;
            $pro->bestseller = $request->has('bestseller') ? 1 : 0;

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $productPath = public_path("uploads/products/{$imageName}");

                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/products'), 0777, true);
                    \File::move($tempPath, $productPath);
                    $pro->image = $imageName;
                }
            }

            $pro->save();

            if ($request->filled('categories')) {
                $categoryIds = $request->categories;
                $pro->categories()->attach($categoryIds);
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
        $product = Product::withoutGlobalScopes()->with('categories', 'productgallery')->findOrFail($id);
        $categories = Category::with('products')->get();
        $authors = Author::all();
        $category_productId = [];
        if ($product->categories()->get() && $product->categories()->get()->count() > 0) {
            $category_productId = $product->categories()->get()->pluck('id')->toArray();
        }
        // dd($category_productId);

        return view('backends.product.edit', compact('product', 'categories', 'authors', 'category_productId'));
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
            'categories' => 'required',
            'author_id' => 'required',
        ]);

        if (is_null($request->name)) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'name',
                    'Name field is required!'
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
            $product->author_id = $request->author_id;
            $product->rating = $request->rating;
            $product->qty = $request->qty;
            $product->price = $request->price;
            $product->pages = $request->pages;
            $product->reviews = $request->reviews;
            $product->format = $request->format;
            $product->barcode = $request->barcode;
            $product->publish = $request->publish;
            $product->created_by = auth()->user()->id;
            $product->new_arrival = $request->has('new-arrival') ? 1 : 0;
            $product->recommended = $request->has('recommended') ? 1 : 0;
            $product->popular = $request->has('popular') ? 1 : 0;
            $product->bestseller = $request->has('bestseller') ? 1 : 0;

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $productPath = public_path("uploads/products/{$imageName}");

                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/products'), 0777, true);
                    \File::move($tempPath, $productPath);
                    $pro->image = $imageName;
                }
            }

            $product->save();

            if ($request->filled('categories')) {
                $categoryIds = $request->categories;
                $product->categories()->sync($categoryIds);
            }

            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Updated successfully')
            ];
        } catch (\Exception $e) {
            // dd($e);
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
            if ($product->image) {
                ImageManager::delete(public_path('uploads/products/' . $product->image));
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

    public function deleteImage(Request $request)
    {
        if (!auth()->user()->can('product.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $product = Product::find($request->product_id);
        if ($product && $product->image) {
            $imagePath = public_path('uploads/products/' . $product->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $product->image = null;
            $product->save();

            return response()->json(['success' => 1, 'msg' => 'Image deleted']);
        }

        return response()->json(['success' => 0, 'msg' => 'Banner or image not found']);
    }

    public function barcode($id)
    {
        $product = Product::findOrFail($id);
        $product_barcode = $product->barcode;
        $generateBarcode = new BarcodeGeneratorHTML();
        $barcode = $generateBarcode->getBarcode($product_barcode, $generateBarcode::TYPE_CODE_128);

        return view('backends.product.barcode', compact('product', 'barcode', 'product_barcode'));
    }
}
