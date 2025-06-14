<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Delivery_Zone;
use App\Models\ShippingCharge;
use App\Models\State;
use App\Models\Street;
use App\Models\SubCity;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ShippingChargeController extends Controller
{

    public function shippingCharges()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_shipping_charge')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();

            $shippingCharges = ShippingCharge::latest()->paginate(20);
            //  dd($shippingCharges);
            return view('admin.shipping.shipping_charges', compact('appsettings', 'shippingCharges'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create($id)
    {
        try {


            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_shipping_charge')) {
                return view('admin.errors.unauthorized');
            }

            $delivery_zoons=Delivery_Zone::all();
            $appsettings = AppSetting::all()->toArray();
            $shipping_charges = ShippingCharge::findOrFail($id);
            return view('admin.shipping.edit_shipping_charges', compact('appsettings', 'shipping_charges','delivery_zoons'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        try {
            if (!$request->method('put')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_shipping_charge')) {
                return view('admin.errors.unauthorized');
            }
            $data = $this->validate($request, [
                'zone' => 'required|string',
                '0_500g' => 'required|numeric',
                '501_1000g' => 'required|numeric',
                '1001_2000g' => 'required|numeric',
                '2001_5000g' => 'required|numeric',
                'above_5000g' => 'required|numeric',
            ]);

            ShippingCharge::where('id', $request->input('id'))
                ->update([
                    '0_500g' => $data['0_500g'],
                    '501_1000g' => $data['501_1000g'],
                    '1001_2000g' => $data['1001_2000g'],
                    '2001_5000g' => $data['2001_5000g'],
                    'above_5000g' => $data['above_5000g'],
                    'zone' => $data['zone'],
                ]);

                    $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update Shipping Charges', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


            Alert::toast('shipping charges is updated!', 'success');
            return redirect('admin/shipping-charges');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }  catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function display()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_shipping_charge')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            $delivery_zoons=Delivery_Zone::all();

            return view('admin.shipping.add_shipping_charge', compact('appsettings', 'delivery_zoons'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function store(Request $request)
    {
        try {
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $data = $this->validate($request, [
                'zone' => 'required | string ',
                '0_500g' => 'required|numeric',
                '501_1000g' => 'required|numeric',
                '1001_2000g' => 'required|numeric',
                '2001_5000g' => 'required|numeric',
                'above_5000g' => 'required|numeric',
            ]);
            $check=ShippingCharge::where('zone', $data['zone'])->first();
            if ($check) {
                Alert::toast('shipping charges is already exist!', 'error');
                return redirect()->back();
            }else{
                     ShippingCharge::create($data);
                        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Create Shipping Charges', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


            }
            // dd($data);

            Alert::toast('shipping charges is saved!', 'success');
            return redirect('admin/shipping-charges');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
         }  catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function destory($shipping_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete_shipping_charge')) {
                return view('admin.errors.unauthorized');
            }
            $shipping = ShippingCharge::find($shipping_id);
            $shipping->delete();

               $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Shipping Charges', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");



            Alert::toast('shipping charges has been deleted!', 'error');
            return redirect('admin/shipping-charges');
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function active($shipping_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_shipping_charge')) {
                return view('admin.errors.unauthorized');
            }
            $shipping = ShippingCharge::find($shipping_id);
            $shipping->status = 1;
            $shipping->update();
            Alert::toast('shipping charges has been actived!', 'success');
            return redirect('admin/shipping-charges');
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function inactive($shipping_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_shipping_charge')) {
                return view('admin.errors.unauthorized');
            }
            $shipping = ShippingCharge::find($shipping_id);
            $shipping->status = 0;
            $shipping->update();
            Alert::toast('shipping charges has been inactived!', 'error');

            return redirect('admin/shipping-charges');
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
