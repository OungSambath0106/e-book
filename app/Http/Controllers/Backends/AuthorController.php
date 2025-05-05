<?php

namespace App\Http\Controllers\Backends;

use App\helpers\ImageManager;
use App\Http\Controllers\Controller;
use App\Models\Author;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('author.view')) {
            abort(403, 'Unauthorized action.');
        }

        $authors = Author::latest('id')->get();
        return view('backends.author.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('author.create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('backends.author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (!auth()->user()->can('author.create')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            // dd($request->all());
            DB::beginTransaction();

            $author = new Author();
            $author->name = $request->name;
            $author->description = $request->description;
            $author->role = $request->role;
            $author->creativity = $request->creativity;
            $author->popularity = $request->popularity;
            $author->social_media = $request->social_media;

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $authorPath = public_path("uploads/authors/{$imageName}");

                // Move image if exists & ensure directory creation
                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/authors'), 0777, true);
                    \File::move($tempPath, $authorPath);
                    $author->image = $imageName;
                }
            }

            $author->save();
            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Created successfully')
            ];
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }

        return redirect()->route('admin.author.index')->with($output);
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
        if (!auth()->user()->can('author.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $author = Author::findOrFail($id);
        return view('backends.author.edit', compact('author'));
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
        if (!auth()->user()->can('author.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $author = Author::findOrFail($id);
            $author->name = $request->name;
            $author->description = $request->description;
            $author->role = $request->role;
            $author->creativity = $request->creativity;
            $author->popularity = $request->popularity;
            $author->social_media = $request->social_media;

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $authorPath = public_path("uploads/authors/{$imageName}");

                if ($author->image && \File::exists(public_path("uploads/authors/{$author->image}"))) {
                    \File::delete(public_path("uploads/authors/{$author->image}"));
                }

                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/authors'), 0777, true);
                    \File::move($tempPath, $authorPath);
                    $author->image = $imageName;
                }
            }

            $author->save();

            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Updated successfully')
            ];
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }

        return redirect()->route('admin.author.index')->with($output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('author.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $author = Author::findOrFail($id);
            if ($author->image) {
                ImageManager::delete(public_path('uploads/authors/' . $author->image));
            }
            $author->delete();
            $authors = Author::latest('id')->get();
            $view = view('backends.author._table', compact('authors'))->render();

            DB::commit();
            $output = [
                'success' => 1,
                'view' => $view,
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
}
