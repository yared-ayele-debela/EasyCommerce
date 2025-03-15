<?php

namespace App\Http\Controllers\Dashboard\RoleAndPermission;

use App\Http\Controllers\Controller;
use App\Models\PermissionCategory;
use App\Models\Permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionController extends Controller
{
    public function index()
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('view permission')) {
            //     Alert::toast('You dont have access to this page.','error');
            //     return redirect()->back();
            //  }
            $permissions = Permissions::paginate(15);
            return view('dashboard.permissions.index', compact('permissions'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('add permission')) {
            //     Alert::toast('You dont have access to this page.','error');
            //     return redirect()->back();
            // }
            // dd($category);
            $permission_category=PermissionCategory::all();
            return view('dashboard.permissions.create',compact('permission_category'));
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
            //     Alert::toast('You dont have access to this page.','error');
            //     return redirect()->back();
            // }
            if (!$request->method('post')) {
                Alert::toast('something is wrong!', 'error');
                return redirect()->back();
            }
            $request->validate([
                'name' => 'required|unique:permissions',

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
            return redirect()->route('permission.index');
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
            //     Alert::toast('You dont have access to this page.','error');
            //     return redirect()->back();
            //       }
            $permission_category=PermissionCategory::all();

            $permission=Permissions::find($id);
            return view('dashboard.permissions.edit', compact('permission','permission_category'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('edit permission')) {
            //     Alert::toast('You dont have access to this page.','error');
            //     return redirect()->back();
            //             }
            if (!$request->method('put')) {
                Alert::toast('something is wrong!', 'error');
                return redirect()->back();
            }
            $permission=Permissions::find($request->input('id'));
            $request->validate([
                'name' => 'required|unique:permissions,name,' . $permission->id,

            ]);

            $permission=Permissions::find($request->input('id'));
            $permission->name=$request->input('name');
            $permission->category_id=$request->input('category_id');

            $permission->update();

            Alert::toast('Permission updated successfully', 'success');
            return redirect()->route('permission.index');
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
            $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('delete permission')) {
            //     Alert::toast('You dont have access to this page.','error');
            //     return redirect()->back();
            //             }
            $permission=Permissions::findOrFail($id);
            $permission->delete();
            Alert::toast('Permission deleted successfully.', 'info');
            return redirect()->route('permission.index');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
