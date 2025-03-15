<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\PermissionCategory;
use App\Models\Permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionsController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view permission')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            $permissions = Permissions::all();
            return view('admin.role_and_permissions.permissions.index', compact('permissions', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add permission')) {
                return view('admin.errors.unauthorized');
            }
            $category=PermissionCategory::all()->where('status',1);
            // dd($category);
            $appsettings = AppSetting::all()->toArray();
            return view('admin.role_and_permissions.permissions.create', compact('category','appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add permission')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->method('post')) {
                Alert::toast('something is wrong!', 'error');
                return redirect()->back();
            }
            $request->validate([
                'name' => 'required|unique:permissions',
                'category_id' => 'required',

            ]);
            // dd($request->all());

            $permission = new Permissions();
            $permission->name=$request->input('name');
            $permission->category_id=$request->input('category_id');
            $permission->save();

            // Permissions::create([
            //     'name' => $request->name,
            //     'category_id' => $request->category_id,
            // ]);

            Alert::toast('Permission created successfully', 'success');
            return redirect()->route('permissions.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function edit(Permissions $permission)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit permission')) {
                return view('admin.errors.unauthorized');
            }
            $category=PermissionCategory::all()->where('status',1);
            $appsettings = AppSetting::all()->toArray();
            return view('admin.role_and_permissions.permissions.edit', compact('category','permission', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request, Permissions $permission)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit permission')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->method('put')) {
                Alert::toast('something is wrong!', 'error');
                return redirect()->back();
            }
            $request->validate([
                'name' => 'required|unique:permissions,name,' . $permission->id,
                'category_id' => 'required',

            ]);

            $permission=Permissions::find($request->input('id'));
            $permission->name=$request->input('name');
            $permission->category_id=$request->input('category_id');
            $permission->update();

            // $permission->update([
            //     'name' => $request->name,
            //     'category_id' => $request->category_id,

            // ]);


            Alert::toast('Permission updated successfully', 'success');
            return redirect()->route('permissions.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function destroy(Permissions $permission)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete permission')) {
                return view('admin.errors.unauthorized');
            }
            $permission->delete();
            Alert::toast('Permission deleted successfully.', 'error');
            return redirect()->route('permissions.index');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}