<?php

namespace App\Http\Controllers\Backends;

use App\helpers\ImageManager;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BusinessSetting;
use App\Models\Translation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('brand.view')) {
            abort(403, 'Unauthorized action.');
        }

        $brands = Brand::latest('id')->get();
        return view('backends.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('brand.create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('backends.brand._create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('brand.create')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->created_by = auth()->user()->id;

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $brandPath = public_path("uploads/brand/{$imageName}");

                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/brand'), 0777, true);
                    \File::move($tempPath, $brandPath);
                    $brand->image = $imageName;
                }
            }

            $brand->save();
            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('Created successfully'),
            ];
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }

        return redirect()->back()->with($output);
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
        if (!auth()->user()->can('brand.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $brand = Brand::withoutGlobalScopes()->findOrFail($id);

        return view('backends.brand._edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('brand.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
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

            $brand = Brand::findOrFail($id);
            $brand->name = $request->name;

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $brandPath = public_path("uploads/brand/{$imageName}");

                // Check if the brand already has an image, then delete it
                if ($brand->image && \File::exists(public_path("uploads/brand/{$brand->image}"))) {
                    \File::delete(public_path("uploads/brand/{$brand->image}"));
                }

                // Move the new file from temp to the final brand directory
                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/brand'), 0777, true);
                    \File::move($tempPath, $brandPath);
                    $brand->image = $imageName;
                }
            }

            $brand->save();
            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('Updated successfully'),
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }

        return redirect()->back()->with($output);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('brand.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();
            $brand = Brand::findOrFail($id);

            if ($brand->image) {
                $imagePath = public_path('uploads/brand/' . $brand->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $brand->delete();
            $brands = Brand::latest('id')->paginate(10);
            $view = view('backends.brand._table', compact('brands'))->render();

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
                'msg' => __('Something when wrong')
            ];
        }

        return response()->json($output);
    }

    public function deleteImage(Request $request)
    {
        if (!auth()->user()->can('brand.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $brand = Brand::find($request->brand_id);
        if ($brand && $brand->image) {
            $imagePath = public_path('uploads/brand/' . $brand->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $brand->image = null;
            $brand->save();

            return response()->json(['success' => 1, 'msg' => 'Image deleted']);
        }

        return response()->json(['success' => 0, 'msg' => 'Brand or image not found']);
    }

    public function updateStatus(Request $request)
    {
        if (!auth()->user()->can('brand.edit')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $brand = Brand::findOrFail($request->id);
            $brand->status = $brand->status == 1 ? 0 : 1;
            $brand->save();

            $output = ['status' => 1, 'msg' => __('Status updated')];

            DB::commit();
        } catch (Exception $e) {

            $output = ['status' => 0, 'msg' => __('Something went wrong')];
            DB::rollBack();
        }

        return response()->json($output);
    }
}
