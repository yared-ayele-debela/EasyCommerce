<?php

namespace App\Http\Controllers\Dashboard\RoleAndPermission;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function index()
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasroleByRole('view role')) {
            //     return view('admin.errors.unauthorized');
            // }
            $roles = Roles::paginate(15);
            return view('dashboard.role.index', compact('roles'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasroleByRole('add role')) {
            //     return view('admin.errors.unauthorized');
            // }
            // dd($category);
            return view('dashboard.role.create');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasroleByRole('add role')) {
            //     return view('admin.errors.unauthorized');
            // }
            if (!$request->method('post')) {
                Alert::toast('something is wrong!', 'error');
                return redirect()->back();
            }
            $request->validate([
                'name' => 'required|unique:roles',

            ]);
            // dd($request->all());

            $role = new roles();
            $role->name=$request->input('name');
            $role->save();

            // roles::create([
            //     'name' => $request->name,
            //     'category_id' => $request->category_id,
            // ]);

            Alert::toast('role created successfully', 'success');
            return redirect()->route('role.index');
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
            // if (!$user || !$user->hasroleByRole('edit role')) {
            //     return view('admin.errors.unauthorized');
            // }
            $role=roles::find($id);
            return view('dashboard.role.edit', compact('role'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {
            // $user = Auth::guard('admin')->user();
            // if (!$user || !$user->hasroleByRole('edit role')) {
            //     return view('admin.errors.unauthorized');
            // }
            if (!$request->method('put')) {
                Alert::toast('something is wrong!', 'error');
                return redirect()->back();
            }
            $role=roles::find($request->input('id'));
            $request->validate([
                'name' => 'required|unique:roles,name,' . $role->id,

            ]);

            $role=roles::find($request->input('id'));
            $role->name=$request->input('name');
            $role->update();

            Alert::toast('Role has been updated!', 'success');
            return redirect()->route('role.index');
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
            // if (!$user || !$user->hasroleByRole('delete role')) {
            //     return view('admin.errors.unauthorized');
            // }
            $role=Roles::findOrFail($id);
            $role->delete();
            Alert::toast('role has been deleted.', 'info');

            return redirect()->route('role.index');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
