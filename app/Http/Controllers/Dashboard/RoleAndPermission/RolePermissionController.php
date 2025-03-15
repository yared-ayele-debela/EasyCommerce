<?php

namespace App\Http\Controllers\Dashboard\RoleAndPermission;

use App\Http\Controllers\Controller;
use App\Models\PermissionCategory;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RolePermissionController extends Controller
{

    public function edit($id)
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('assign permission')) {
            //     Alert::toast('You dont have access to this page.','error');
            //     return redirect()->back();
            // }

            $roles = Roles::find($id);
            $permissions = Permissions::all();
            $permissions = PermissionCategory::with('permissions')->get();
            // dd($permissions);

            return view('dashboard.permissions.role_permissions.edit', compact('roles', 'permissions'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
        }

        public function update(Request $request ,Roles $role)
        {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasPermissionByRole('assign permission')) {
            //     Alert::toast('You dont have access to this page.','error');
            //     return redirect()->back();
            // }


            if (!$request->method('put')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $request->validate([
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            $role->permissions()->sync($request->permissions);
            Alert::toast('Permissions assigned to role successfully.', 'success');
            return redirect()->route('role.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
