<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AppSetting;
use App\Models\Roles;
use App\Models\Vendor;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_admin')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();

            $users = Admin::all();
            return view('admin.role_and_permissions.admins.index', compact('users', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function assignRole(Admin $user)
    {
        try {
            $users = Auth::guard('admin')->user();
            if (!$users || !$users->hasPermissionByRole('assign_role')) {
                return view('admin.errors.unauthorized');
            }

            $roles = Roles::all();
            $appsettings = AppSetting::all()->toArray();

            return view('admin.role_and_permissions.admins.assing_role', compact('user', 'roles', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function updateRole(Request $request, Admin $user)
    {

        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:admins,id',
        ]);

        try {
            $admin = Admin::find($request->input('user_id'));

            if (!$admin) {
                Alert::toast('Admin does not exist!', 'error');
                return redirect()->route('all-admins.index');
            }

            $newRole = Roles::find($request->role_id);
            $newGroup = $newRole->group ?? null;

            if (!$newRole) {
                Alert::toast('Role does not exist!', 'error');
                return redirect()->route('all-admins.index');
            }

            // Get current role group
            $currentRole = $admin->roles()->first();
            $currentGroup = $currentRole->group ?? null;

            // Group types that require a vendor entry
            $vendorGroups = ['ecommerce', 'hotel', 'restaurant'];

            // CASE 1: If current group is ecommerce, and new group is not in vendor groups → delete vendor
            if ($currentGroup === 'ecommerce' && !in_array(needle: $newGroup, $vendorGroups)) {
                Vendor::where('email', $admin->email)->delete();
                $admin->vendor_id = null;
            }

            // CASE 2: If new group is ecommerce, hotel, or restaurant → insert/update vendor
            if (in_array($newGroup, $vendorGroups)) {
                // Check if vendor already exists
                $vendor = Vendor::where('email', $admin->email)->first();

                if (!$vendor) {
                    $vendor = new Vendor();
                }

                $vendor->name = $admin->name;
                $vendor->mobile = $admin->mobile;
                $vendor->email = $admin->email;
                $vendor->status = 1;
                $vendor->confirm = "Yes";
                $vendor->vendor_type = $newGroup;
                $vendor->save();

                $admin->vendor_id = $vendor->id;
            }

            // Update admin's type and role
            $admin->type = $newRole->name;
            $admin->save();
            $admin->roles()->sync([$request->role_id]);

            // Log
            ActivityLogger::log('Assign Role', Auth::guard('admin')->user()->name . " at " . now()->toDateTimeString());


            Alert::toast('Role assigned to user successfully!', 'success');
            return redirect()->route('all-admins.index');
        } catch (\Exception $e) {
            Alert::toast('Something went wrong!', 'error');
            return redirect()->route('all-admins.index');
        }
    }
}