<?php

namespace App\Http\Controllers\Admin\DeliveryMan;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Vehicle_Type;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class VehicleTypeController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view vehicle type')) {
                return view('admin.errors.unauthorized');
            }
            $vehicle_type = Vehicle_Type::paginate(10);
            $appsettings = AppSetting::all()->toArray();
            return view('admin.vehicle_type.index', compact('vehicle_type', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('Error occurred while fetching data!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add vehicle type')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            return view('admin.vehicle_type.create', compact('appsettings'));
        } catch (\Exception $e) {
            Alert::toast('Error occurred while creating!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add vehicle type')) {
                return view('admin.errors.unauthorized');
            }
            $request->validate([
                'name' => 'required|unique:vehicle__types'
            ]);

            $vehicle_type = new Vehicle_Type();
            $vehicle_type->name = $request->input('name');
            $vehicle_type->status = 1;
            $vehicle_type->save();

            
         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add Vehicle Type', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");



            Alert::toast('Vehicle type has been added successfully!', 'success');
            return redirect()->route('vehicle_type');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('Error occurred while adding Vehicle type!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit vehicle type')) {
                return view('admin.errors.unauthorized');
            }
            $vehicle_type = Vehicle_Type::find($id);
            $appsettings = AppSetting::all()->toArray();

            return view('admin.vehicle_type.edit', compact('vehicle_type', 'appsettings'));
        } catch (ModelNotFoundException $e) {
            Alert::toast('Error occurred while loading the vehicle type. Please try again.', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit vehicle type')) {
                return view('admin.errors.unauthorized');
            }
            $request->validate([
                'name' => 'required'
            ]);

            $vehicle_type = Vehicle_Type::find($request->input('id'));
            if (!$vehicle_type) {
                Alert::toast('Vehicle type not found!', 'error');
                return redirect()->back();
            }

            $vehicle_type->name = $request->input('name');
            $vehicle_type->update();

              $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update Vehicle Type', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");



            Alert::toast('Vehicle type has been updated successfully!', 'success');
            return redirect()->route('vehicle_type');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('Error occurred while updating Vehicle type!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete vehicle type')) {
                return view('admin.errors.unauthorized');
            }
            $vehicle_type = Vehicle_Type::find($id);
            if (!$vehicle_type) {
                Alert::toast('Vehicle type not found!', 'error');
                return redirect()->back();
            }

            $vehicle_type->delete();

            Alert::toast('Vehicle type has been deleted successfully!', 'error');
            return redirect()->route('vehicle_type');
        } catch (\Exception $e) {
            Alert::toast('Error occurred while deleting Vehicle type!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function active($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit vehicle type')) {
                return view('admin.errors.unauthorized');
            }
            $vehicle_type = Vehicle_Type::find($id);
            if (!$vehicle_type) {
                Alert::toast('Vehicle type not found!', 'error');
                return redirect()->back();
            }

            $vehicle_type->status = 1;
            $vehicle_type->save();

            Alert::toast('Vehicle type has been activated!', 'success');
            return redirect()->route('vehicle_type');
        } catch (\Exception $e) {
            Alert::toast('Error occurred while activating Vehicle type!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function inactive($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit vehicle type')) {
                return view('admin.errors.unauthorized');
            }
            $vehicle_type = Vehicle_Type::find($id);
            if (!$vehicle_type) {
                Alert::toast('Vehicle type not found!', 'error');
                return redirect()->back();
            }

            $vehicle_type->status = 0;
            $vehicle_type->save();

            Alert::toast('Vehicle type has been inactivated successfully!', 'error');
            return redirect()->route('vehicle_type');
        } catch (\Exception $e) {
            Alert::toast('Error occurred while inactivating Vehicle type!', 'error');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}