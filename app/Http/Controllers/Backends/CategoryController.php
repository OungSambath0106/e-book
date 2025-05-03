<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('category.view')) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::latest('id')->get();
        return view('backends.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('category.create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('backends.category._create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('category.create')) {
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
            $category = new Category();
            $category->name = $request->name;
            $category->created_by = auth()->user()->id;

            $category->save();
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
        if (!auth()->user()->can('category.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $category = Category::withoutGlobalScopes()->findOrFail($id);

        return view('backends.category._edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('category.edit')) {
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

            $category = Category::findOrFail($id);
            $category->name = $request->name;

            $category->save();
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
        if (!auth()->user()->can('category.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();
            $category = Category::findOrFail($id);

            $category->delete();
            $categories = Category::latest('id')->paginate(10);
            $view = view('backends.category._table', compact('categories'))->render();

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
        if (!auth()->user()->can('category.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $category = Category::find($request->category_id);
        $category->save();

        return response()->json(['success' => 0, 'msg' => 'Category not found']);
    }

    public function updateStatus(Request $request)
    {
        if (!auth()->user()->can('category.edit')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $category = Category::findOrFail($request->id);
            $category->status = $category->status == 1 ? 0 : 1;
            $category->save();

            $output = ['status' => 1, 'msg' => __('Status updated')];

            DB::commit();
        } catch (Exception $e) {

            $output = ['status' => 0, 'msg' => __('Something went wrong')];
            DB::rollBack();
        }

        return response()->json($output);
    }
}
