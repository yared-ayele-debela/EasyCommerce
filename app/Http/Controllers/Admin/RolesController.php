<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Roles;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view role')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            $roles = Roles::all();
            return view('admin.role_and_permissions.roles.index', compact('roles', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add role')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            return view('admin.role_and_permissions.roles.create', compact('appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add role')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $request->validate([
                'name' => 'required|unique:roles',
                'group' => 'required|string|in:hotel,restaurant,ecommerce', // allowed groups
            ]);

            Roles::create([
                'name' => $request->name,
                'group' => $request->group,
            ]);

               $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Create Role', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


            Alert::toast('Role has been created successfully!', 'success');
            return redirect()->route('roles.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function edit(Roles $role)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit role')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            return view('admin.role_and_permissions.roles.edit', compact('role', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request, Roles $role)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit role')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->method('put')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $request->validate([
                'name' => 'required|unique:roles,name,' . $role->id,
                'group' => 'required|string|in:hotel,restaurant,ecommerce', // allowed groups
            ]);

            $role->update([
                'name' => $request->name,
                'group' => $request->group,
            ]);

               $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update Role', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");



            Alert::toast('Role has been updated successfully.', 'success');
            return redirect()->route('roles.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function destroy(Roles $role)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete role')) {
                return view('admin.errors.unauthorized');
            }

            $role->delete();


               $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log(  'Delete Role', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


            Alert::toast('Role has been deleted successfully', 'error');
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
