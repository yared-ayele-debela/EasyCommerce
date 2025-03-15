<?php

namespace App\Http\Controllers\Admin\DeliveryMan;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Delivery_Zone;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DeliveryZoneController extends Controller
{
    public function index()
    {
        try {

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view delivery zone')) {
                return view('admin.errors.unauthorized');
            }
            $delivery_zone = Delivery_Zone::paginate(10);
            $appsettings = AppSetting::all()->toArray();
            return view('admin.delivery_zone.index', compact('delivery_zone', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('Error occurred while fetching data!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add delivery zone')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            return view('admin.delivery_zone.create', compact('appsettings'));
        } catch (\Exception $e) {
            Alert::toast('Error occurred while creating!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add delivery zone')) {
                return view('admin.errors.unauthorized');
            }
            $request->validate([
                'name' => 'required|unique:delivery__zones'
            ]);

            $delivery_zone = new Delivery_Zone();
            $delivery_zone->name = $request->input('name');
            $delivery_zone->status = 1;
            $delivery_zone->save();

            Alert::toast('Delivery zone has been added successfully!', 'success');
            return redirect()->route('delivery_zone');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('Error occurred while adding Delivery zone!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit delivery zone')) {
                return view('admin.errors.unauthorized');
            }
            $delivery_zone = Delivery_Zone::findOrFail($id);
            $appsettings = AppSetting::all()->toArray();

            return view('admin.delivery_zone.edit', compact('delivery_zone', 'appsettings'));
        } catch (ModelNotFoundException $e) {
            Alert::toast('Error occurred while loading the delivery zone. Please try again.', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit delivery zone')) {
                return view('admin.errors.unauthorized');
            }
            $request->validate([
                'name' => 'required|unique:delivery__zones'
            ]);

            $delivery_zone = Delivery_Zone::findOrFail($request->input('id'));
            $delivery_zone->name = $request->input('name');
            $delivery_zone->update();

            Alert::toast('Delivery zone has been updated successfully!', 'success');
            return redirect()->route('delivery_zone');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            Alert::toast('Error occurred while updating the delivery zone. Please try again.', 'error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete delivery zone')) {
                return view('admin.errors.unauthorized');
            }
            $delivery_zone = Delivery_Zone::find($id);
            $delivery_zone->delete();

            Alert::toast('Delivery zone has been deleted successfully!', 'error');
            return redirect()->route('delivery_zone');
        } catch (\Exception $e) {
            Alert::toast('Error occurred while deleting the delivery zone!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function active($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit delivery zone')) {
                return view('admin.errors.unauthorized');
            }
            $delivery_zone = Delivery_Zone::find($id);
            $delivery_zone->status = 1;
            $delivery_zone->save();

            Alert::toast('Delivery zone has been activated!', 'success');
            return redirect()->route('delivery_zone');
        } catch (\Exception $e) {
            Alert::toast('Error occurred while activating the delivery zone!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function inactive($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit delivery zone')) {
                return view('admin.errors.unauthorized');
            }
            $delivery_zone = Delivery_Zone::find($id);
            $delivery_zone->status = 0;
            $delivery_zone->save();

            Alert::toast('Delivery zone has been inactivated successfully!', 'error');
            return redirect()->route('delivery_zone');
        } catch (\Exception $e) {
            Alert::toast('Error occurred while inactivating the delivery zone!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
