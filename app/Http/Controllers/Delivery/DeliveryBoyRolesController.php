<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\DeliveryMan;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DeliveryBoyRolesController extends Controller
{
    public function index()
    {
        try{
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_delivery_boy')) {
            return view('admin.errors.unauthorized');
        }

        $appsettings=AppSetting::all()->toArray();

        $users = DeliveryMan::paginate(4);
        return view('admin.role_and_permissions.delivery_boy.index', compact('users','appsettings'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function assignRole(DeliveryMan $user)
    {
        try{
        $users = Auth::guard('admin')->user();
        if (!$users || !$users->hasPermissionByRole('assign_role')) {
            return view('admin.errors.unauthorized');
        }

        $roles = Roles::all();
        $appsettings=AppSetting::all()->toArray();

        return view('admin.role_and_permissions.delivery_boy.assing_role', compact('user','roles','appsettings'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function updateRole(Request $request, DeliveryMan $user)
    {
        try{
        $users = Auth::guard('admin')->user();
        if (!$users || !$users->hasPermissionByRole('assign_role')) {
            return view('admin.errors.unauthorized');
        }
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->roles()->sync([$request->role_id]);

        return redirect()->route('all-delivery-boy.index')->with('success', 'Role assigned to user successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
        // Laravel's built-in validation exception
          return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }
}
