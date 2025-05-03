<?php

namespace App\Http\Controllers\Backends;

use App\helpers\ImageManager;
use App\Http\Controllers\Controller;
use App\Models\Baner;
use App\Models\BusinessSetting;
use App\Models\Translation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BanerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('banner.view')) {
            abort(403, 'Unauthorized action.');
        }

        $banners = Baner::latest('id')->get();
        return view('backends.banner-slider.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('banner.create')) {
            abort(403, 'Unauthorized action.');
        }

        $language = BusinessSetting::where('type', 'language')->first();
        $language = $language->value ?? null;
        $default_lang = 'en';
        $default_lang = json_decode($language, true)[0]['code'];

        return view('backends.banner-slider._create', compact('language', 'default_lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('banner.create')) {
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

            $baner = new Baner;
            $baner->name = $request->name;

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $banerPath = public_path("uploads/banner-slider/{$imageName}");

                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/banner-slider'), 0777, true);
                    \File::move($tempPath, $banerPath);
                    $baner->image = $imageName;
                }
            }

            $baner->created_by = auth()->user()->id;
            $baner->save();

            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Create successfully'),
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }

        return redirect()->route('admin.banner-slider.index')->with($output);
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
        if (!auth()->user()->can('banner.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $baner = Baner::withoutGlobalScopes()->findOrFail($id);
        return view('backends.banner-slider._edit', compact('baner'));
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
        if (!auth()->user()->can('banner.edit')) {
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

            $baner = Baner::findOrFail($id);
            $baner->name = $request->name;

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $banerPath = public_path("uploads/banner-slider/{$imageName}");

                if ($baner->image && \File::exists(public_path("uploads/banner-slider/{$baner->image}"))) {
                    \File::delete(public_path("uploads/banner-slider/{$baner->image}"));
                }

                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/banner-slider'), 0777, true);
                    \File::move($tempPath, $banerPath);
                    $baner->image = $imageName;
                }
            }

            $baner->save();

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

        return redirect()->route('admin.banner-slider.index')->with($output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('banner.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();
            $baner = Baner::findOrFail($id);

            if ($baner->image) {
                $imagePath = public_path('uploads/banner-slider/' . $baner->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $baner->delete();
            $view = view('backends.banner-slider._table', ['banners' => Baner::latest()->get()])->render();

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
        if (!auth()->user()->can('banner.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $baner = Baner::find($request->baner_id);
        if ($baner && $baner->image) {
            $imagePath = public_path('uploads/banner-slider/' . $baner->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $baner->image = null;
            $baner->save();

            return response()->json(['success' => 1, 'msg' => 'Image deleted']);
        }

        return response()->json(['success' => 0, 'msg' => 'Banner or image not found']);
    }

    public function updateStatus(Request $request)
    {
        if (!auth()->user()->can('banner.edit')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $baner = Baner::findOrFail($request->id);
            $baner->status = $baner->status == 1 ? 0 : 1;
            $baner->save();

            $output = ['status' => 1, 'msg' => __('Status updated')];

            DB::commit();
        } catch (Exception $e) {

            // dd($e);
            $output = ['status' => 0, 'msg' => __('Something went wrong')];
            DB::rollBack();
        }

        return response()->json($output);
    }
}
