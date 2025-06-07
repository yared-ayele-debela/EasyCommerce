<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\CmsPage;
use App\Models\Country;
use App\Models\Delivery_Zone;
use App\Models\State;
use App\Models\SubCity;
use App\Models\Vendor;
use App\Models\VendorBankDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RestaurantAdminController extends Controller
{
    public function updatevendordetails()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();
            $country = Country::where('status', 1)->get();
            $states=State::all();
            $cities=City::all();
            $subcities=SubCity::all();
            $vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first();
            if(!$vendorDetails){
                Alert::toast('Your Vendor Information is not avaliable','info');
                return redirect()->back();
            }
            $zones=Delivery_Zone::all();
            return view(view: 'Restaurant.dashboard.vendor.updatevendordetails', data: compact('zones','vendorDetails', 'country', 'appsettings', 'cms_pages','states','cities','subcities'));
        } catch (\Exception $e) {
            Alert::toast(title:  'Something is wrong!', icon: 'error');
            return redirect()->back();
        }
    }
    public function updatevendorbankdetails()
    {

        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();


            $vendorCount = VendorBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
            if ($vendorCount > 0) {
                $VendorBankDetails = VendorBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            } else {
                $VendorBankDetails = array();
            }
            return view(view: 'Restaurant.dashboard.vendor.updatevendorbankdetails', data: compact('VendorBankDetails', 'appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}