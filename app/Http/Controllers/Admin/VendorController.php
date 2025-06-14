<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Middleware\Admin;
use App\Models\Admin as ModelsAdmin;
use App\Models\AppSetting;
use App\Models\CmsPage;
use App\Models\EmailTemplate;
use App\Models\Vendor;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class VendorController extends Controller
{
   public function vendors(Request $request){

    $cms_pages = CmsPage::get()->toArray();
    $appsettings = AppSetting::all()->toArray();
    $allvendor=Vendor::where('status',1);

    $allvendors=$allvendor->all();
    $search = $request->input('search');
    if($search) {
    $allvendors=$allvendor->where('name',$search)->get();
    }
    return view('NewFrontEndPage.lists.vendors.allvendors',compact('cms_pages','appsettings','allvendors'));
   }

    public function index()
    {
        try {
            $cms_pages = CmsPage::get()->toArray();
            $appsettings = AppSetting::all()->toArray();
            return view('NewFrontEndPage.vendor.login_register', compact('cms_pages', 'appsettings'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function active($vendor_id)
    {
        try {
            $vendor = ModelsAdmin::where('vendor_id', $vendor_id)->first();
            $vendor->status = 1;
            $vendor->update();

            $vendoraccount = Vendor::where('id', $vendor_id)->first();
            $vendoraccount->status = 1;
            $vendoraccount->update();

            $adminDetails = ModelsAdmin::where('vendor_id', $vendor_id)->first()->toArray();
            $email_template = EmailTemplate::first();

            if ($adminDetails['type'] == "vendor" && $adminDetails['status'] == 1) {
                $email = $adminDetails['email'];
                $messageData = [
                    'email_template' => $email_template,
                    'email' => $adminDetails['email'],
                    'name' => $adminDetails['name'],
                    'mobile' => $adminDetails['mobile']
                ];
                Mail::send('emails.vendor_approved', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Vendor Account is Approved');
                });
            }
            Alert::toast('Vendor status activated!', 'success');

            return redirect()->back();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function inactive_vendor($vendor_id)
    {
        try {
            $vendor = ModelsAdmin::where('vendor_id', $vendor_id)->first();
            if($vendor){
                $vendor->status = 0;
                $vendor->update();
            }

            $vendoraccount = Vendor::where('id', $vendor_id)->first();
            // dd($vendoraccount);
            if($vendoraccount){
                $vendoraccount->status = 0;
                $vendoraccount->update();
            }

            Alert::toast('Vendor status inactived!', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function vendor_details($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_vendor_detail')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();
            $vendorDetails = Vendor::find($id);
            $id = $vendorDetails->id;
            if ($id == 0) {
                return redirect()->back();
            }

            $vendorDetails = Vendor::with(['vendorbusinessdetails', 'vendorBank'])->find($id);
            $vendorDetails = json_decode(json_encode($vendorDetails), true);

            return view('admin.vendor.vendor_view_details', compact('appsettings', 'vendorDetails', 'cms_pages'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function allvendors()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $vendor = Vendor::where('id', '<>', '0')->get();

            return view('admin.vendor.allvendors', compact('vendor', 'appsettings'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $vendor = Vendor::find($id);
            if ($vendor) {
                $vendor->delete();
                ModelsAdmin::where('vendor_id', $id)->delete();

                    $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Vendor', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

            }
            Alert::toast('Vendor has been deleted!', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}