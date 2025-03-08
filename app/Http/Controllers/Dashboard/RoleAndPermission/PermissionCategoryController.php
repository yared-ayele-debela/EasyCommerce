<?php

namespace App\Http\Controllers\Dashboard\RoleAndPermission;

use App\Http\Controllers\Controller;
use App\Models\PermissionCategory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionCategoryController extends Controller
{
    public function index()
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('view permission')) {
            //     return view('admin.errors.unauthorized');
            // }
            $permission_category = PermissionCategory::paginate(15);
            return view('dashboard.permissions.category.index', compact('permission_category'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('add permission')) {
            //     return view('admin.errors.unauthorized');
            // }
            // dd($category);
            return view('dashboard.permissions.category.create');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('add permission')) {
            //     return view('admin.errors.unauthorized');
            // }
            if (!$request->method('post')) {
                Alert::toast('something is wrong!', 'error');
                return redirect()->back();
            }
            $request->validate([
                'name' => 'required|unique:permission_categories',

            ]);
            // dd($request->all());

            $permission = new PermissionCategory();
            $permission->name=$request->input('name');
            $permission->save();

            // Permissions::create([
            //     'name' => $request->name,
            //     'category_id' => $request->category_id,
            // ]);

            Alert::toast('Permission created successfully', 'success');
            return redirect()->route('permission.category.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('edit permission')) {
            //     return view('admin.errors.unauthorized');
            // }
            $category=PermissionCategory::find($id);
            return view('dashboard.permissions.category.edit', compact('category'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('edit permission')) {
            //     return view('admin.errors.unauthorized');
            // }
            if (!$request->method('put')) {
                Alert::toast('something is wrong!', 'error');
                return redirect()->back();
            }
            $permission=PermissionCategory::find($request->input('id'));
            $request->validate([
                'name' => 'required|unique:permission_categories,name,' . $permission->id,

            ]);

            $permission=PermissionCategory::find($request->input('id'));
            $permission->name=$request->input('name');
            $permission->update();

            Alert::toast('Permission updated successfully', 'success');
            return redirect()->route('permission.category.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('delete permission')) {
            //     return view('admin.errors.unauthorized');
            // }
            $permission=PermissionCategory::findOrFail($id);
            $permission->delete();
            Alert::toast('Permission deleted successfully.', 'error');
            return redirect()->route('permission.category.index');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function active($id){
        $permission=PermissionCategory::findOrFail($id);
        $permission->status=1;
        $permission->update();

        Alert::toast('Permission category has been actived!','success');
        return redirect()->back();

    }

    public function inactive($id){
        $permission=PermissionCategory::findOrFail($id);
        $permission->status=0;
        $permission->update();

        Alert::toast('Permission category has been inactived!','info');
        return redirect()->back();
    }
}
