<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use SebastianBergmann\Environment\Runtime;

class ColorController extends Controller
{
    //
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_color')) {
                return view('admin.errors.unauthorized');
            }
            $colors = Color::all();
            $appsettings = AppSetting::all()->toArray();

            return view('admin.color.index', compact('colors', 'appsettings'));
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!','error');
            return redirect()->back();        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add_color')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            return view('admin.color.create', compact('appsettings'));
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!','error');
            return redirect()->back();        }
    }
    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add_color')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('post')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->route('colors');
            }

            $request->validate([
                'name' => 'required|unique:colors',
                'color' => 'required' // You might add further validation for the color input
            ]);

            $color = new Color();
            $color->name = $request->input('name');
            $color->color = $request->input('color');
            $color->status = 1;
            $color->save();

            Alert::toast('Color has been saved successfully!', 'success');
            return redirect()->route('colors');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_color')) {
                return view('admin.errors.unauthorized');
            }
            $color = Color::find($id);
            $appsettings = AppSetting::all()->toArray();

            return view('admin.color.edit', compact('color', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_color')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('put')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->route('colors');
            }

            $request->validate([
                'name' => 'required|',
                'color' => 'required' // You might add further validation for the color input
            ]);

            $color = Color::find($request->input('id'));
            $color->name = $request->input('name');
            $color->color = $request->input('color');
            $color->update();

            Alert::toast('Color has been updated successfully!', 'success');
            return redirect()->route('colors');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete_color')) {
                return view('admin.errors.unauthorized');
            }
            $color = Color::find($id);
            $color->delete();

            Alert::toast('Color has been deleted successfully!', 'error');
            return redirect()->route('colors');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_color')) {
                return view('admin.errors.unauthorized');
            }
            $color = Color::find($id);
            $color->status = 1;
            $color->save();

            Alert::toast('Color has been activated!', 'success');
            return redirect()->route('colors');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function inactive($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_color')) {
                return view('admin.errors.unauthorized');
            }
            $color = Color::find($id);
            $color->status = 0;
            $color->save();

            Alert::toast('Color has been inactivated successfully!', 'error');
            return redirect()->route('colors');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }
}
