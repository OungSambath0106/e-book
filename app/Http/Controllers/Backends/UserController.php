<?php

namespace App\Http\Controllers\Backends;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\helpers\ImageManager;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('user.view')) {
            abort(403, 'Unauthorized action.');
        }
        $users = User::when($request->start_date && $request->end_date, function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);
        })
            ->latest('id')
            ->get();

        return view('backends.user.index', compact('users'));
    }
    public function create()
    {
        if (!auth()->user()->can('user.create')) {
            abort(403, 'Unauthorized action.');
        }
        $roles = Role::select('name','id')
                ->pluck('name','id');

        return view('backends.user.create', compact('roles'));
    }
    public function store(Request $request)
    {
        if (!auth()->user()->can('user.create')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->telegram = $request->telegram ?? null;
            $user->email = $request->email;
            $user->password = Hash::make($request['password']);

            $role = Role::findOrFail($request->role);
            $user->assignRole($role->name);

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $userPath = public_path("uploads/users/{$imageName}");

                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/users'), 0777, true);
                    \File::move($tempPath, $userPath);
                    $user->image = $imageName;
                }
            }

            $user->save();
            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Created successfully')
            ];
        } catch (Exception $e) {
            DB::rollBack();
            // dd($e);
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }

        return redirect()->route('admin.user.index')->with($output);
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

    public function edit($id)
    {
        if (!auth()->user()->can('user.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $roles = Role::select('name','id')
                ->pluck('name','id');
        return view('backends.user.edit', compact('user', 'roles'));
    }
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('user.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->telegram = $request->telegram ?? null;
            $user->email = $request->email;

            // Update Role if changed
            $newRole = Role::findOrFail($request->role);
            if (!$user->hasRole($newRole->name)) {
                $user->syncRoles([$newRole->name]);
            }

            // Update Password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Handle Image Update
            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $userPath = public_path("uploads/users/{$imageName}");

                if ($user->image && \File::exists(public_path("uploads/users/{$user->image}"))) {
                    \File::delete(public_path("uploads/users/{$user->image}"));
                }

                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/users'), 0777, true);
                    \File::move($tempPath, $userPath);
                    $user->image = $imageName;
                }
            }

            $user->save();
            DB::commit();

            return redirect()->route('admin.user.index')->with(['success' => 1, 'msg' => __('Updated successfully')]);

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('User Update Error: ' . $e->getMessage());

            return redirect()->back()->with(['success' => 0, 'msg' => __('Something went wrong')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('user.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            if ($user->image) {
                ImageManager::delete(public_path('uploads/users/' . $user->image));
            }
            $user->delete();
            $users = User::latest('id')->paginate(10);
            $view = view('backends.user._table', compact('users'))->render();

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
        if (!auth()->user()->can('user.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::find($request->user_id);
        if ($user && $user->image) {
            $imagePath = public_path('uploads/users/' . $user->image);

            // Delete the image from storage
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Remove image reference from database
            $user->image = null;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Image deleted']);
        }

        return response()->json(['success' => false, 'message' => 'User or image not found']);
    }

    public function showProfile()
    {
        if (!auth()->user()->can('user.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('backends.user.profile');
    }
    public function updateProfile(Request $request)
    {
        if (!auth()->user()->can('user.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'password' => 'nullable|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $id = auth()->user()->id;
            $user = User::findOrFail($id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->telegram = $request->telegram ?? null;
            $user->email = $request->email;

            if ($request->password) {
                $user->password = Hash::make($request['password']);
            }

            if ($request->filled('image_names')) {
                $imageName = $request->image_names;
                $tempPath = public_path("uploads/temp/{$imageName}");
                $userPath = public_path("uploads/users/{$imageName}");

                if ($user->image && \File::exists(public_path("uploads/users/{$user->image}"))) {
                    \File::delete(public_path("uploads/users/{$user->image}"));
                }

                if (\File::exists($tempPath)) {
                    \File::ensureDirectoryExists(public_path('uploads/users'), 0777, true);
                    \File::move($tempPath, $userPath);
                    $user->image = $imageName;
                }
            }

            $user->save();
            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Updated successfully')
            ];
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }
        return redirect()->back()->with($output);
    }
}
