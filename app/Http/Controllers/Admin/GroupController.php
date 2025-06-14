<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupFormRequest;
use App\Models\AppSetting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Guid\Guid;
use RealRashid\SweetAlert\Facades\Alert;

class GroupController extends Controller
{
    //
    public function index()
    {
        // try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_group')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();
            $group = Group::all();
            return view('admin.group.allgroup', compact('group', 'appsettings'));
        // } catch (\Exception $e) {
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_group')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();
            return view('admin.group.addgroup', compact('appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_group')) {
                return view('admin.errors.unauthorized');
            }

            $group = new Group();
            $group->name = $request['name'];
            $group->description = $request['description'];

            $group->save();

             $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add Group', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

            Alert::toast('Group has been created!', 'success');

            return redirect('admin/groups');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request, $group_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_group')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('put')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->back();
            }

            $group = Group::findOrFail($group_id);
            $group->name = $request['name'];
            $group->description = $request['description'];

            $group->update();

                    $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log(  'Update Group', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

            Alert::toast('Group has been updated!', 'success');

            return redirect('admin/groups');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function edit($group_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_group')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();
            $group = Group::find($group_id);
            return view('admin.group.editgroup', compact('group', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function destory($group_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete_group')) {
                return view('admin.errors.unauthorized');
            }

            $group = Group::find($group_id);
            $group->delete();

                    $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Group', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

            Alert::toast('Group has been deleted!', 'error');
            return redirect('admin/groups');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function active($group_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_group')) {
                return view('admin.errors.unauthorized');
            }
            $group = Group::find($group_id);
            $group->status = 1;
            $group->update();
            Alert::toast('Group activated!', 'success');
            return redirect('admin/groups');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function inactive($group_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_group')) {
                return view('admin.errors.unauthorized');
            }
            $group = Group::find($group_id);
            $group->status = 0;
            $group->update();
            Alert::toast('Group inactivated!', 'error');
            return redirect('admin/groups');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}