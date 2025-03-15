<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\PermissionCategory;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RolePermissions extends Controller
{
    public function edit($id)
    {
        // try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('assign role')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();
            $roles = Roles::find($id);
            $permissions = Permissions::all();
            $permissions = PermissionCategory::with('permissions')->get();
            // dd($permissions);

            return view('admin.role_and_permissions.role_permissions.edit', compact('appsettings', 'roles', 'permissions'));
        // } catch (\Exception $e) {
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
    }

    public function update(Request $request, Roles $role)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('assign role')) {
                return view('admin.errors.unauthorized');
            }

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
            return redirect()->route('roles.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
