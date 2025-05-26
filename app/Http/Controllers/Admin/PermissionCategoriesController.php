<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\PermissionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionCategoriesController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view permission category')) {
                return view('admin.errors.unauthorized');
            }
            $permission_categories = PermissionCategory::latest()->paginate(10);
            $appsettings = AppSetting::all()->toArray();

            return view('admin.role_and_permissions.permissions.category.index', compact('permission_categories', 'appsettings'));
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add permission category')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            return view('admin.role_and_permissions.permissions.category.create', compact('appsettings'));
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add permission category')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('post')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->route('cities'); // You can redirect to an appropriate location
            }

            $request->validate([
                'name' => 'required|unique:permission_categories'
            ]);

            $category = new PermissionCategory();
            $category->name = $request->input('name');
            $category->status = 1;
            $category->save();

            Alert::toast('Permission category has been saved successfully!', 'success');
            return redirect()->route('permissions-categories');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit permission category')) {
                return view('admin.errors.unauthorized');
            }
            $permission_categories = PermissionCategory::find($id);
            $appsettings = AppSetting::all()->toArray();

            return view('admin.role_and_permissions.permissions.category.edit', compact('permission_categories', 'appsettings'));
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit permission category')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('put')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->route('cities'); // You can redirect to an appropriate location
            }
            $request->validate([
                'name' => 'required'
            ]);

            $category = PermissionCategory::find($request->input('id'));
            $category->name = $request->input('name');
            $category->save();

            Alert::toast('Permission category has been updated successfully!', 'success');
            return redirect()->route('permissions-categories');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete permission category')) {
                return view('admin.errors.unauthorized');
            }
            $category = PermissionCategory::find($id);
            $category->delete();

            Alert::toast('Permission category has been deleted successfully!', 'error');
            return redirect()->route('permissions-categories');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        try {
            $category = PermissionCategory::find($id);
            $category->status = 1;
            $category->save();

            Alert::toast('Permission category has been activated!', 'success');
            return redirect()->route('permissions-categories');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function inactive($id)
    {
        try {
            $category = PermissionCategory::find($id);
            $category->status = 0;
            $category->save();

            Alert::toast('Permission category has been inactivated successfully!', 'error');
            return redirect()->route('permissions-categories');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}