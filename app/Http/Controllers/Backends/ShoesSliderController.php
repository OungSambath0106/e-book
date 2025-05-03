<?php

namespace App\Http\Controllers\Backends;

use App\helpers\ImageManager;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\ShoesSlider;
use App\Models\Translation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShoesSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('shoes_slider.view')) {
            abort(403, 'Unauthorized action.');
        }

        $shoessliders = ShoesSlider::latest('id')->get();

        return view('backends.shoes-slider.index', compact('shoessliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('shoes_slider.create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('backends.shoes-slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('shoes_slider.create')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if (is_null($request->title)) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'title',
                    'title field is required!'
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

            $shoesslider = new ShoesSlider();
            $shoesslider->title = $request->title;

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $shoesSliderPath = public_path("uploads/shoes-slider/{$imageName}");

                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/shoes-slider'), 0777, true);
                    \File::move($tempPath, $shoesSliderPath);
                    $shoesslider->image = $imageName;
                }
            }

            $shoesslider->save();

            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Created successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }
        return redirect()->route('admin.shoes-slider.index')->with($output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('shoes_slider.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $shoesslider = ShoesSlider::withoutGlobalScopes()->findOrFail($id);
        return view('backends.shoes-slider.edit', compact('shoesslider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('shoes_slider.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if (is_null($request->title)) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'title',
                    'title field is required!'
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

            $shoesslider =  ShoesSlider::findOrFail($id);
            $shoesslider->title = $request->title;

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $shoesSliderPath = public_path("uploads/shoes-slider/{$imageName}");

                if ($shoesslider->image && \File::exists(public_path("uploads/shoes-slider/{$shoesslider->image}"))) {
                    \File::delete(public_path("uploads/shoes-slider/{$shoesslider->image}"));
                }

                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/shoes-slider'), 0777, true);
                    \File::move($tempPath, $shoesSliderPath);
                    $shoesslider->image = $imageName;
                }
            }
            $shoesslider->save();

            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Created successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }
        return redirect()->route('admin.shoes-slider.index')->with($output);
    }

    public function updateStatus(Request $request)
    {
        if (!auth()->user()->can('shoes_slider.edit')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $shoesslider = ShoesSlider::findOrFail($request->id);
            $shoesslider->status = $shoesslider->status == 1 ? 0 : 1;
            $shoesslider->save();

            $output = ['status' => 1, 'msg' => __('Status updated')];

            DB::commit();
        } catch (Exception $e) {

            $output = ['status' => 0, 'msg' => __('Something went wrong')];
            DB::rollBack();
        }

        return response()->json($output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('shoes_slider.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();
            $shoesslider = ShoesSlider::findOrFail($id);

            if ($shoesslider->image) {
                $imagePath = public_path('uploads/shoes-slider/' . $shoesslider->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $shoesslider->delete();

            $shoessliders = ShoesSlider::latest('id')->get();
            $view = view('backends.shoes-slider._table', compact('shoessliders'))->render();

            DB::commit();
            $output = [
                'success' => 1,
                'view'  => $view,
                'msg' => __('Deleted successfully')
            ];
        } catch (Exception $e) {
            dd($e);
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
        if (!auth()->user()->can('shoes_slider.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $shoesslider = ShoesSlider::find($request->shoesslider_id);
        if ($shoesslider && $shoesslider->image) {
            $imagePath = public_path('uploads/shoes-slider/' . $shoesslider->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $shoesslider->image = null;
            $shoesslider->save();

            return response()->json(['success' => 1, 'msg' => 'Image deleted']);
        }

        return response()->json(['success' => 0, 'msg' => 'Banner or image not found']);
    }
}
