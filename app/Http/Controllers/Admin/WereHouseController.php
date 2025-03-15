<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Admin;
use App\Models\Admin as ModelsAdmin;
use App\Models\AppSetting;
use App\Models\Country;
use App\Models\WarehouseManager;
use App\Models\WereHouses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class WereHouseController extends Controller
{
    //
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view warehouse')) {
                return view('admin.errors.unauthorized');
            }
            $alladmin = ModelsAdmin::all()->where('type', 'stock_caper');
            // dd($alladmin);
            $allwerehouses = WereHouses::all();
            $appsettings = AppSetting::all()->toArray();

            return view('admin.werehoue.index', compact('allwerehouses', 'appsettings', 'alladmin'));
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_warehouse')) {
                return view('admin.errors.unauthorized');
            }
            $allcountires = Country::all()->where('status', 1);
            $appsettings = AppSetting::all()->toArray();
            return view('admin.werehoue.add', compact('appsettings', 'allcountires'));
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_warehouse')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $validatedData = $request->validate([
                'name' => 'required|string',
                'code' => 'required|string',
                'address' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
                'country' => 'required|string',
                'state' => 'required|string',
            ]);

            $warehouse = new WereHouses();
            $warehouse->name = $validatedData['name'];
            $warehouse->code = $validatedData['code'];
            $warehouse->address = $validatedData['address'];
            $warehouse->phone = $validatedData['phone'];
            $warehouse->email = $validatedData['email'];
            $warehouse->country = $validatedData['country'];
            $warehouse->state = $validatedData['state'];
            $warehouse->status = 0;

            $warehouse->save();

            Alert::toast('Warehouse Added Successfully!', 'success');
            return redirect()->route('warehouses.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }  catch (\Exception $e) {
            // Log the error for debugging purposes
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function edit($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_warehouse')) {
                return view('admin.errors.unauthorized');
            }
            $allcountires = Country::all()->where('status', 1);
            $appsettings = AppSetting::all()->toArray();
            $warehouse = WereHouses::findOrFail($id);
            return view('admin.werehoue.edit', compact('warehouse', 'appsettings', 'allcountires'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_warehouse')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->method('put')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $validatedData = $request->validate([
                'name' => 'required|string',
                'code' => 'required|string',
                'address' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
                'country' => 'required|string',
                'state' => 'required|string',
            ]);

            $warehouse = WereHouses::findOrFail($id);
            $warehouse->name = $validatedData['name'];
            $warehouse->code = $validatedData['code'];
            $warehouse->address = $validatedData['address'];
            $warehouse->phone = $validatedData['phone'];
            $warehouse->email = $validatedData['email'];
            $warehouse->country = $validatedData['country'];
            $warehouse->state = $validatedData['state'];

            $warehouse->save();

            Alert::toast('Warehouse Updated Successfully!', 'success');
            return redirect()->route('warehouses.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('An error occurred while updating the warehouse.', 'error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete_warehouse')) {
                return view('admin.errors.unauthorized');
            }

            $warehouse = WereHouses::findOrFail($id);
            if($warehouse->id=="1"){
                Alert::toast('You don`t have permission to delete this warehouse','error');
                return redirect()->back();
            }else{
                $warehouse->delete();

                Alert::toast('Warehouse deleted successfully!', 'success');
                return redirect()->route('warehouses.index');
            }

        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }



    public function active($id)
    {
        // dd($id);
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_warehouse')) {
                return view('admin.errors.unauthorized');
            }
            $warehouse = WereHouses::find($id);
            $warehouse->status = 1;
            $warehouse->update();

            Alert::toast('Warehouse status is active!', 'success');
            return redirect('admin/all-warehouse');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'info');
            return redirect()->back();
        }
    }

    public function inactive($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_warehouse')) {
                return view('admin.errors.unauthorized');
            }
            $warehouse = WereHouses::find($id);
            $warehouse->status = 0;
            $warehouse->update();

            Alert::toast('Warehouse status is inactive!', 'error');
            return redirect('admin/all-warehouse');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function assign_warehouse()
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('assign user to warehouse')) {
         Alert::toast('you don`t have permission to access ','error');
          return redirect()->back();
        }
        $users = ModelsAdmin::where('type', 'Stock Manager')->get();
        // dd($users);
        $warehouses = WereHouses::where('status', 1)->get();
        $assigned = WarehouseManager::with('admin', 'warehouse')->get();
        // dd($assigned);
        return view('admin.werehoue.assign_warehouse', compact('users', 'warehouses', 'assigned'));
    }

    public function assign(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('assign user to warehouse')) {
         Alert::toast('you don`t have permission to access ','error');
          return redirect()->back();
        }
        try{
        $request->validate([
            'user_id' => 'required',
            'warehouse_id' => 'required',
        ]);

        //  dd($request->all());
        $user_id = $request->input('user_id');
        $warehouse_id = $request->input('warehouse_id');

        $manager = ModelsAdmin::find($user_id);
        $warehouse = WereHouses::find($warehouse_id);

        $check_user = WarehouseManager::where('manager_id', $user_id)->first();
        $check_warehouse=WarehouseManager::with('admin','warehouse')->where('warehouse_id',$warehouse_id)->first();

        // if ($check_user || $check_warehouse !=null) {
           if ($check_user != null) {
            Alert::toast("User already assigned to ".$check_user->warehouse->name." warehouse.", "warning");
            return back();
            }
            if($check_warehouse != null){
                Alert::toast("Warehouse already assigned to ".$check_warehouse->admin->name." user .", "warning");
                return back();
            }

            if ($manager && $warehouse) {
                $manager->warehouses()->attach($warehouse_id);
                Alert::toast('Assigned Successfully', 'success');
                return redirect()->back();
            } else {
                Alert::toast('User or warehouse not found', 'error');
                return redirect()->back();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch(\Exception $e) {
            Alert::toast('Something went wrong! Please try again later','error');
             return redirect()->back();
        }

    }

    public function delete_assigned($id){
        $find=WarehouseManager::findOrfail($id);

        if($find){
            $find->delete();
        }
        Alert::toast('Assigned user to warehouse has been deleted ','info');
        return redirect()->back();
    }
}
