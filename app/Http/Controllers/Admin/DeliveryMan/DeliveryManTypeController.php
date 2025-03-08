<?php

namespace App\Http\Controllers\Admin\DeliveryMan;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Delivery_Man_Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DeliveryManTypeController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view deliveryman type')) {
                return view('admin.errors.unauthorized');
            }
            $delivery_man_type = Delivery_Man_Type::paginate(10);
            $appsettings = AppSetting::all()->toArray();
            return view('admin.delivery_man_type.index', compact('delivery_man_type', 'appsettings'));

        } catch (\Exception $e) {
            Alert::toast('Error occurred while fetching data!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add deliveryman type')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            return view('admin.delivery_man_type.create', compact('appsettings'));
        } catch (\Exception $e) {
            Alert::toast('Error occurred while creating!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add deliveryman type')) {
                return view('admin.errors.unauthorized');
            }
            $request->validate([
                'name' => 'required|unique:delivery__man__types'
            ]);

            $Delivery_Man_Type = new Delivery_Man_Type();
            $Delivery_Man_Type->name = $request->input('name');
            $Delivery_Man_Type->status = 1;
            $Delivery_Man_Type->save();

            Alert::toast('Delivery_Man_Type has been added successfully!', 'success');
            return redirect()->route('delivery_man_type');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('Error occurred while adding Delivery_Man_Type!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit deliveryman type')) {
                return view('admin.errors.unauthorized');
            }
            $delivery_man_type = Delivery_Man_Type::find($id);
            $appsettings = AppSetting::all()->toArray();
            return view('admin.delivery_man_type.edit', compact('delivery_man_type', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('Error occurred while editing!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit deliveryman type')) {
                return view('admin.errors.unauthorized');
            }
            $request->validate([
                'name' => 'required|unique:delivery__man__types'
            ]);

            $Delivery_Man_Type = Delivery_Man_Type::find($request->input('id'));
            if (!$Delivery_Man_Type) {
                Alert::toast('Delivery_Man_Type not found!', 'error');
                return redirect()->back();
            }

            $Delivery_Man_Type->name = $request->input('name');
            $Delivery_Man_Type->update();

            Alert::toast('Delivery_Man_Type has been updated successfully!', 'success');
            return redirect()->route('delivery_man_type');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('Error occurred while updating Delivery_Man_Type!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete deliveryman type')) {
                return view('admin.errors.unauthorized');
            }
            $Delivery_Man_Type = Delivery_Man_Type::find($id);
            if (!$Delivery_Man_Type) {
                Alert::toast('Delivery_Man_Type not found!', 'error');
                return redirect()->back();
            }

            $Delivery_Man_Type->delete();

            Alert::toast('Delivery_Man_Type has been deleted successfully!', 'error');
            return redirect()->route('delivery_man_type');
        } catch (\Exception $e) {
            Alert::toast('Error occurred while deleting Delivery_Man_Type!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function active($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit deliveryman type')) {
                return view('admin.errors.unauthorized');
            }
            $Delivery_Man_Type = Delivery_Man_Type::find($id);
            if (!$Delivery_Man_Type) {
                Alert::toast('Delivery_Man_Type not found!', 'error');
                return redirect()->back();
            }

            $Delivery_Man_Type->status = 1;
            $Delivery_Man_Type->save();

            Alert::toast('Delivery_Man_Type has been activated!', 'success');
            return redirect()->route('delivery_man_type');
        } catch (\Exception $e) {
            Alert::toast('Error occurred while activating Delivery_Man_Type!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function inactive($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit deliveryman type')) {
                return view('admin.errors.unauthorized');
            }
            $Delivery_Man_Type = Delivery_Man_Type::find($id);
            if (!$Delivery_Man_Type) {
                Alert::toast('Delivery_Man_Type not found!', 'error');
                return redirect()->back();
            }

            $Delivery_Man_Type->status = 0;
            $Delivery_Man_Type->save();

            Alert::toast('Delivery_Man_Type has been inactivated successfully!', 'error');
            return redirect()->route('delivery_man_type');
        } catch (\Exception $e) {
            Alert::toast('Error occurred while inactivating Delivery_Man_Type!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
