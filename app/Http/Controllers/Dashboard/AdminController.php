<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Roles;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PDO;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    //
    public function index()
    {
        $admins = Admin::paginate(20);

        return view('dashboard.admin.index', compact('admins'));
    }

    public function create()
    {

        return view('dashboard.admin.create');
    }

    public function store(Request $request)
    {
        try {

            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $this->validate($request, [
                'name' => 'required',
                'email' => 'email',
                'mobile' => 'required',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required'
            ]);
            // dd($request->all());

            $adminCount = Admin::where('email', $request->input('email'))->count();
            if ($adminCount > 0) {
                Alert::toast('Admin already exists', 'error');
                return redirect()->back();
            }
            $adminmobile = Admin::where('mobile', $request->input('mobile'))->first();
            //   dd($adminmobile);
            if ($adminmobile != null) {
                Alert::toast('Admin mobile number exists', 'error');
                return redirect()->back();
            }
            $admin = new Admin();

            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->mobile = $request->input('mobile');
            $admin->password = Hash::make($request->input('password'));

            if ($request->hasFile('image')) {
                if ($admin->image) {
                    Storage::delete('public/admin/image/' . $admin['image']);
                }
                //get file name with ext
                $fileNameWithExt = $request->file('image')->getClientOriginalName();
                //get just file name
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                //get just file extenstion
                $extension = $request->file('image')->getClientOriginalExtension();
                //file name to store
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                //upload image
                $path = $request->file('image')->storeAs('public/admin/image', $fileNameToStore);

                $admin->image = $fileNameToStore;
            }
            $admin->save();

            Alert::toast('Admin has been created!', 'success');
            return redirect()->route('show-all-admins');
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

            $admin = Admin::findOrFail($id);
            return view('dashboard.admin.edit', compact('admin'));
        } catch (Exception) {
            Alert::toast('Something is wrong ', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {

            if (!$request->method('put')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $this->validate($request, [
                'name' => 'required',
                'email' => 'email',
                'mobile' => 'required',

            ]);

            $admin = Admin::find($request->input('id'));

            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->mobile = $request->input('mobile');

            if ($request->hasFile('image')) {
                if ($admin->image) {
                    Storage::delete('public/admin/image/' . $admin->image);
                }
                //get file name with ext
                $fileNameWithExt = $request->file('image')->getClientOriginalName();
                //get just file name
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                //get just file extenstion
                $extension = $request->file('image')->getClientOriginalExtension();
                //file name to store
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                //upload image
                $path = $request->file('image')->storeAs('public/admin/image', $fileNameToStore);

                $admin->image = $fileNameToStore;
            }
            $admin->update();

            Alert::toast('Admin has been updated!', 'success');
            return redirect()->route('show-all-admins');
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

            $admin = Admin::findOrFail($id);
            if ($admin->image) {
                Storage::delete('public/admin/image/' . $admin->image);
            }
            $admin->delete();
            Alert::toast('Admin has been deleted!', 'warning');
            return redirect()->back();
        } catch (Exception) {
            Alert::toast('Something is wrong ', 'error');
            return redirect()->back();
        }
    }

    public function active($id){
        $admin=Admin::findOrFail($id);
        $admin->status=1;
        $admin->save();
        Alert::toast('Admin Account Activated Successfully','success');
        return redirect()->back();
    }
    public function deactive($id){
        $admin=Admin::findOrFail($id);
        $admin->status=0;
        $admin->save();
        Alert::toast('Admin Account Deactivated Successfully','info');
        return redirect()->back();
    }


    public function assignRole($id)
    {
        try {
            // $users = Auth::guard('admin')->user();
            // if (!$users || !$users->hasPermissionByRole('assign role')) {
            //     Alert::toast('You dont have access to this page.','error');
            //     return redirect()->back();
            //  }

            $roles = Roles::all();
            $admin=Admin::findOrFail($id);
            // $appsettings = AppSetting::all()->toArray();

            return view('dashboard.admin.assign_role', compact('admin', 'roles'));

        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function updateRole(Request $request)
    {
        if (!$request->isMethod('post')) {
            // Display an error or handle the incorrect request method
            Alert::toast('Invalid request method!', 'error');
            return redirect()->route('all-admins.index');
        }

        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'admin_id' => 'required|exists:admins,id',
        ]);

        try {
            $role = Roles::find($request->input('role_id'));
            if (!$role) {
                Alert::toast('Role does not exist!', 'error');
                return redirect()->route('all-admins.index');
            }

            $admin = Admin::find($request->input('admin_id'));

            if (!$admin) {
                Alert::toast('Admin does not exist!', 'error');
                return redirect()->route('all-admins.index');
            }

            $admin->type = $role->name;
            $admin->update();

            $admin->roles()->sync([$request->role_id]);

            Alert::toast('Role assigned to user successfully!', 'success');
            return redirect()->route('show-all-admins');
        } catch (\Exception $e) {
            Alert::toast('Something went wrong!', 'error');
            return redirect()->route('all-admins');
        }
    }
}
