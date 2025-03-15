<?php

namespace App\Http\Controllers;

use App\Livewire\Admin\AdminList;
use App\Models\Admin;
use App\Models\AdminsRole;
use App\Models\AppSetting;
use Illuminate\Support\Str;
use App\Models\CmsPage;
use App\Models\Country;
use App\Models\EmailTemplate;
use App\Models\Roles;
use App\Models\Vendor;
use App\Models\VendorBankDetails;
use App\Models\VendorBussinessDetails;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    // for update admin password
    public function update_admin_password(Request $request)
    {
        try {
            if (!$request->method('put')) {
                Alert::toast('Error', 'Something is wrong!', 'error');
                return redirect()->back();
            }
            $request->validate([
                'oldpassword' => 'required',
                'new_password' => ['required'],
                'new_password_confirmation' => ['same:new_password'],
            ]);
            // return $request->all();
            if (!Hash::check($request->oldpassword, Auth::guard('admin')->user()->password)) {
                Alert::toast('your old password is not correct!', 'error');
                return back();
            }
            // Current password and new password same
            if (!strcmp($request->get('new_password'), $request->get('new_password_confirmation')) == 0) {
                Alert::toast('new password and confirm password  not the same!', 'error');
                return back();
            }
            #Update the new Password
            Admin::whereId(Auth::guard('admin')->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            ActivityLogger::log('Change password', "user changed their password");



            Alert::toast('Password Updated Succesfully !', 'success');
            return back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }
    public function updateadminpassword()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();

            return view('admin.auth.updateadminpassword', compact('adminDetails', 'appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }


    //for upate admin details
    public function updateadmindetails()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();
            $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
            return view('admin.auth.updateadmindetails', compact('adminDetails', 'appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }


    public function update_admin_details(Request $request)
    {

        try {
            if (!$request->method('put')) {
                Alert::toast('Something is wrong!!', 'error');
                return redirect()->back();
            }
            $this->validate($request, [
                'image' => 'image',
                'name' => ['required', 'alpha'],
                'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:10'
            ]);

            $admin = Admin::find(Auth::guard('admin')->user()->id);
            $admin->name = $request->input('name');
            $admin->mobile = $request->input('mobile');
            if ($request->hasFile('image')) {
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
                if ($admin->product_image != 'noimage.jpg') {
                    Storage::delete('public/admin/image' . $admin->image);
                }
                $admin->image = $fileNameToStore;
            }

            $admin->update();
            ActivityLogger::log('Update detail', "user updated their detail information");

            Alert::toast('Admin details has been updated!', 'success');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }



    //for display login page
    public function loginpage()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            return view('admin.auth.login', compact('appsettings'));
        } catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }

    //for check if admin login or not
    public function loginvalidate(Request $request)
    {

        try {
            if (!$request->method('post')) {
                Alert::toast('Error', 'Something is wrong!', 'error');
                return redirect()->back();
            }

            $data = $request->all();
            $validateData = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1])) {
                if (Auth::guard('admin')->user()->type == "vendor" & Auth::guard('admin')->user()->confirm == "No") {

                    Alert::toast('Please confirm your email to active your Vendor Account', 'error');
                    return redirect()->back();
                } else if (Auth::guard('admin')->user()->type != "vendor" && Auth::guard('admin')->user()->status = "0") {
                    Alert::toast('Your account is not acitve', 'error');
                    return redirect()->back();
                } else {

                    $currentDateTime = Carbon::now();
                    $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'

                    ActivityLogger::log('User login', "user login at {$formattedDateTime}");
                    Alert::toast('Welcome to Dashboard', 'success');
                    return redirect('/admin/dashboard');
                }
            } else {
                Alert::toast('Your email or password is incorrect', 'error');
                return redirect()->back();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }  catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }
    public function logout()
    {
        try {
            $appsettings = AppSetting::all()->toArray();

            $currentDateTime = Carbon::now();
            $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
            ActivityLogger::log('User logout', "User logout at {$formattedDateTime}");
            Auth::guard('admin')->logout();

            return view('admin.auth.login', compact('appsettings'));
        } catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }

    //for update vendor details,vendor bank details and vendor business details


    public function updatevendordetails()
    {
        try {

            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();
            $country = Country::where('status', 1)->get();
            $vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            return view('admin.vendor.updatevendordetails', compact('vendorDetails', 'country', 'appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }



    public function update_vendor_details(Request $request)
    {
        try {
            if (!$request->method('put')) {
                Alert::toast('Error', 'Something is wrong!', 'error');
                return redirect()->back();
            }
            $data = $request->all();
            if ($request->hasFile('vendor_image')) {

                //get file name with ext
                $fileNameWithExt = $request->file('vendor_image')->getClientOriginalName();
                //get just file name
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                //get just file extenstion
                $extension = $request->file('vendor_image')->getClientOriginalExtension();
                //file name to store
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                //upload image
                $path = $request->file('vendor_image')->storeAs('public/admin/image', $fileNameToStore);

                if ('image') {
                    Storage::delete('public/admin/image/' . $data['vendor_image']);
                }

                Admin::where('id', Auth::guard('admin')->user()->id)->update([
                    'image' => $fileNameToStore
                ]);
            }

            Admin::where('id', Auth::guard('admin')->user()->id)->update([
                'name' => $data['vendor_name'], 'mobile' => $data['vendor_mobile']
            ]);


            Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->update([
                'name' => $data['vendor_name'],
                'mobile' => $data['vendor_mobile'],
                'city' => $data['vendor_city'],
                'state' => $data['vendor_state'],
                'address' => $data['vendor_address'],
                'mobile' => $data['vendor_mobile'],
                'country' => $data['vendor_country'],
                'pincode' => $data['vendor_pincode']
            ]);
            ActivityLogger::log('Update detail', "user updated their detail information");


            Alert::toast('Update vendor details successfully!', 'success');
            return redirect()->back();

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }



    public function updatevendorbusinessdetails()
    {
        try {
            $country = Country::where('status', 1)->get();
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            $vendorCount = VendorBussinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();

            if ($vendorCount > 0) {

                $vendorbusiness = VendorBussinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            } else {
                $vendorbusiness = array();
            }
            return view('admin.vendor.updatevendorbusinessdetails', compact('appsettings', 'vendorbusiness', 'country', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }

    //for update Vendor Commissions
    public function updateVendorCommission(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $data = $request->all();
                Vendor::where('id', $data['vendor_id'])->update(['commission' => $data['commission']]);
                ActivityLogger::log('Update Vendor Information', "update vendor commission");

                Alert::toast('Vendor commission updated!', 'success');

                return  redirect()->back();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
        catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }

    public function update_vendor_businessdetails(Request $request)
    {
        try {
            if (!$request->method('put')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }

            $data = $request->all();
            // dd($data);
            $vendor=VendorBussinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first();
            $vendorCount = VendorBussinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();

            if ($vendorCount > 0) {
                if ($request->hasFile('address_proof_image')) {

                    //get file name with ext
                    $fileNameWithExt = $request->file('address_proof_image')->getClientOriginalName();
                    //get just file name
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    //get just file extenstion
                    $extension = $request->file('address_proof_image')->getClientOriginalExtension();
                    //file name to store
                    $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                    //upload image
                    $path = $request->file('address_proof_image')->storeAs('public/admin/image', $fileNameToStore);

                    if ($vendor->address_proof_image) {
                        Storage::delete('public/admin/image/'.$vendor->address_proof_image);
                    }
                } else if (!empty($data['current_address_proof'])) {
                    $fileNameToStore = $data['current_address_proof'];
                } else {
                    $fileNameToStore = "";
                }

                VendorBussinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                    'address_proof_image' => $fileNameToStore
                ]);

                //shoping image
                if ($request->hasFile('shop_image')) {
                    // dd('hello');

                    //get file name with ext
                    $fileNameWithExt = $request->file('shop_image')->getClientOriginalName();
                    //get just file name
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    //get just file extenstion
                    $extension = $request->file('shop_image')->getClientOriginalExtension();
                    //file name to store
                    $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                    //upload image
                    $path = $request->file('shop_image')->storeAs('public/admin/image', $fileNameToStore);

                    if ($vendor->shop_image) {
                        Storage::delete('public/admin/image/'.$vendor->shop_image);
                    }

                } else if (!empty($data['current_shop_image'])) {
                    $fileNameToStore = $data['current_shop_image'];
                } else {
                    $fileNameToStore = "";
                }

                VendorBussinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                    'shop_image' => $fileNameToStore
                ]);

                VendorBussinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                    'shop_name' => $data['shop_name'],
                    'shop_mobile' => $data['shop_mobile'],
                    'shop_address' => $data['shop_address'],
                    'shop_city' => $data['shop_city'],
                    'shop_state' => $data['shop_state'],
                    'shop_website' => $data['shop_website'],
                    'shop_country' => $data['shop_country'],
                    'business_license_number' => $data['business_license_number'],
                    'shop_email' => $data['shop_email'],
                    'address_proof' => $data['address_proof'],
                    'shop_pincode' => $data['shop_pincode'],
                ]);
            } else {

                if ($request->hasFile('address_proof_image')) {

                    //get file name with ext
                    $fileNameWithExt = $request->file('address_proof_image')->getClientOriginalName();
                    //get just file name
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    //get just file extenstion
                    $extension = $request->file('address_proof_image')->getClientOriginalExtension();
                    //file name to store
                    $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                    //upload image
                    $path = $request->file('address_proof_image')->storeAs('public/admin/image', $fileNameToStore);

                    if ($vendor->address_proof_image) {
                        Storage::delete('public/admin/image/'.$vendor->address_proof_image);
                    }
                } else if (!empty($data['current_address_proof'])) {
                    $fileNameToStore = $data['current_address_proof'];
                } else {
                    $fileNameToStore = "";
                }

                //shoping image
                if ($request->hasFile('shop_image')) {

                    // dd("hello");
                    //get file name with ext
                    $fileNameWithExt = $request->file('shop_image')->getClientOriginalName();
                    //get just file name
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    //get just file extenstion
                    $extension = $request->file('shop_image')->getClientOriginalExtension();
                    //file name to store
                    $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                    //upload image
                    $path = $request->file('shop_image')->storeAs('public/admin/image', $fileNameToStore);

                    if ($vendor->shop_image) {
                        Storage::delete('public/admin/image/'.$vendor->shop_image);
                    }

                } else if (!empty($data['shop_image'])) {

                    $fileNameToStores = $data['shop_image'];
                    VendorBussinessDetails::insert([
                        'vendor_id', Auth::guard('admin')->user()->vendor_id,
                        'shop_image' => $fileNameToStores
                    ]);
                } else {
                    $fileNameToStores = "";
                }

                VendorBussinessDetails::insert([
                    'vendor_id' => Auth::guard('admin')->user()->vendor_id,
                    'address_proof_image' => $fileNameToStore
                ]);

                VendorBussinessDetails::insert([
                    'vendor_id' => Auth::guard('admin')->user()->vendor_id,
                    'shop_name' => $data['shop_name'],
                    'shop_mobile' => $data['shop_mobile'],
                    'shop_address' => $data['shop_address'],
                    'shop_city' => $data['shop_city'],
                    'shop_state' => $data['shop_state'],
                    'shop_website' => $data['shop_website'],
                    'shop_country' => $data['shop_country'],
                    'business_license_number' => $data['business_license_number'],
                    'shop_email' => $data['shop_email'],
                    'address_proof' => $data['address_proof'],
                    'shop_pincode' => $data['shop_pincode'],
                ]);
            }
            ActivityLogger::log('Update', "update vendor detail");

            Alert::toast('Upated vendor business details Successfully!', 'success');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
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

            return view('admin.vendor.updatevendorbankdetails', compact('VendorBankDetails', 'appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function update_vendor_bank_details(Request $request)
    {
        try {
            if (!$request->method('put')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $data = $request->all();
            $vendorCount = VendorBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
            if ($vendorCount > 0) {
                VendorBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                    'account_holder_name' => $data['account_holder_name'],
                    'bank_name' => $data['bank_name'],
                    'account_number' => $data['account_number'],
                ]);
            } else {
                VendorBankDetails::insert([
                    'vendor_id' => Auth::guard('admin')->user()->vendor_id,
                    'account_holder_name' => $data['account_holder_name'],
                    'bank_name' => $data['bank_name'],
                    'account_number' => $data['account_number'],
                ]);
            }
            ActivityLogger::log('Update', "update vendor bank information");

            Alert::toast('Upated vendor bank details successfully!', 'success');

            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    // for active and inactive admin type

    public function active_user($vendor_id)
    {
        try {

            $vendor = Admin::where('vendor_id', $vendor_id)->first();
            $vendor->status = 1;
            $vendor->update();
            // $admin=Vendor::where('id',$vendor_id)->update(['status'=>1]);
            Alert::toast('Admin status has been actived!', 'success');

            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function inactive_user($vendor_id)
    {
        try {
            $vendor = Admin::where('vendor_id', $vendor_id)->first();
            $vendor->status = 0;
            $vendor->update();


            Alert::toast('Admin status has been inactived!', 'info');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }



    public function display_vendor()
    {

        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            $vendor = Admin::where('type', 'vendor')->get()->toArray();

            return view('admin.vendor.allvendors', compact('vendor', 'appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function displayall()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_all_admins')) {
                return view('admin.errors.unauthorized');
            }

            return view('admin.admin.all')->withComponent(AdminList::class);
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    //for view details about vendor
    public function viewVendorDetails($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_vendor_detail')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            $vendorDetails = Admin::with(['vendorPersonal', 'vendorBusiness', 'vendorBank'])->find($id);
            $vendorDetails = json_decode(json_encode($vendorDetails), true);
            //  dd($vendorDetails);
            return view('admin.vendor.vendor_view_details', compact('appsettings', 'vendorDetails', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function adminsubadmins()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            $admin_subadmins = Admin::all();
            return view('admin.admin.admin_and_subadmin', compact('appsettings', 'admin_subadmins', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function  active_admin_and_subadmin($id)
    {
        try {
            $admin = Admin::find($id);
            $admin->status = 1;
            $admin->update();
            Alert::toast('Admin status has been actived!', 'success');
            ActivityLogger::log('Update', "update admin status to active");

            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function  inactive_admin_and_subadmin($id)
    {
        try {
            $admin = Admin::find($id);
            $admin->status = 0;
            $admin->update();
            ActivityLogger::log('Update', "update admin status to inactive");
            Alert::toast('Admin status has been inactive!', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public  function delete_admin_and_subadmin($id)
    {
        try {
            $admin = Admin::find($id);
            $admin->delete();
            ActivityLogger::log('Delete', " delete admin");

            Alert::toast('Admin has been deleted!', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function add_admin_or_subadmin()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_admin')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            $all_admin = Admin::all();
            $role = Roles::all();
            return view('admin.admin.add_admin_and_subadmin', compact('appsettings', 'role', 'all_admin', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store_admin_or_subadmin(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_admin')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $this->validate($request, [
                'name' => 'required',
                'email' => 'email',
                'mobile' => 'required',
                'password' => 'required'
            ]);
            //            dd($request->all());
            $adminCount = Admin::where('email', $request->input('email'))->count();
            if ($adminCount > 0) {
                Alert::toast('Admin/sub-admin already exists', 'error');
                return redirect()->back();
            }
            $adminmobile = Admin::where('mobile', $request->input('mobile'))->first();
            //   dd($adminmobile);
            if ($adminmobile != null) {
                Alert::toast('Admin/sub-admin mobile number exists', 'error');
                return redirect()->back();
            }
            $admin = new Admin();

            $admin->name = $request->input('name');
            $admin->type = $request->input('type');
            $admin->email = $request->input('email');
            $admin->mobile = $request->input('mobile');
            $admin->password = Hash::make($request->input('password'));


            if ($request->hasFile('image')) {
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
            ActivityLogger::log('Create', "Create admin user");


            Alert::toast('Admin/sub-admin has been created!', 'success');
            return redirect()->route('alladmins');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public  function edit_admin_or_subadmin($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_admin')) {
                return view('admin.errors.unauthorized');
            }
            $role = Roles::all();
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            $admin = Admin::find($id);
            return view('admin.admin.edit_admin_and_subadmin', compact('role', 'admin', 'appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update_admin_or_subadmin(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_admin')) {
                return view('admin.errors.unauthorized');
            }

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
            $admin->type = $request->input('type');
            $admin->email = $request->input('email');
            $admin->mobile = $request->input('mobile');

            if ($request->hasFile('image')) {

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

                if ('image') {
                    Storage::delete('public/admin/image/' . $admin['image']);
                }
                $admin->image = $fileNameToStore;
            }

            $admin->update();
            ActivityLogger::log('Update', "update admin information");


            Alert::toast('Admin/sub-admin has been updated', 'success');
            return redirect('admin/all/admins');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function updateRole(Request $request, $id)
    {
        try {
            if ($request->isMethod('post')) {
                $data = $request->all();
                unset($data['_token']);
                AdminsRole::where('admin_id', $id)->delete();

                foreach ($data as $key => $value) {
                    if (isset($value['view'])) {
                        $view = $value['view'];
                    } else {
                        $view = 0;
                    }
                    if (isset($value['edit'])) {
                        $edit = $value['edit'];
                    } else {
                        $edit = 0;
                    }
                    if (isset($value['full'])) {
                        $full = $value['full'];
                    } else {
                        $full = 0;
                    }
                    AdminsRole::where('admin_id', $id)->insert(['admin_id' => $id, 'module' => $key, 'view_access' => $view, 'edit_access' => $edit, 'full_access' => $full]);
                }


                Alert::toast('Roles has been updated successfully!', 'success');
                return redirect()->back();
            }
            $appsettings = AppSetting::all()->toArray();
            $adminDetails = Admin::where('id', $id)->first()->toArray();
            $adminRoles = AdminsRole::where('admin_id', $id)->get()->toArray();
            return view('admin.admin.admin_role.update_roles', compact('appsettings', 'adminDetails', 'adminRoles'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function ForgetPassword()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            return view('admin.forget_password.forget', compact('appsettings'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function ForgetPasswordStore(Request $request)
    {
        if (!$request->isMethod('post')) {
            // Display an error or handle the incorrect request method
            Alert::toast('Invalid request method!', 'error');
            return back();
        }

        $request->validate([
            'email' => 'required|email|exists:admins',
        ]);

        // try {
            $token = Str::random(64);

            DB::table('password_resets')->updateOrInsert([
                'email' => $request->email,
            ],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            $email_template = EmailTemplate::first();
            $messageData = [
                'token' => $token,
                'email_template' => $email_template,
            ];

            Mail::send('emails.reset-password',$messageData, function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });
            // Mail::send('emails.order', $messageData, function ($message) use ($email) {
            //     $message->to($email)->subject('Order Placed - BYT Developers');
            // });

            // Mail::send('emails.reset-password', $messageData, function ($message) use ($request, $token) {
            //     $message->to($request->email)
            //         ->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'))
            //         ->subject('Reset Password')
            //         ->with(['token' => $token]);
            // });

            Alert::toast('We have emailed your password reset link', 'success');
            return back();
        // } catch (\Exception $e) {
        //     // Log or handle the exception as needed
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
    }
    public function ResetPassword($token)
    {
        try {

            $appsettings = AppSetting::all()->toArray();
            return view('admin.forget_password.forget-password-link',compact('appsettings'), ['token' => $token]);
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function ResetPasswordStore(Request $request)
    {
        // dd($request->all());

        if (!$request->isMethod('post')) {
            // Display an error or handle the incorrect request method
            Alert::toast('Invalid request method!', 'error');
            return back();
        }

        $request->validate([
            'email' => 'required|email|exists:admins',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        $update = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

        if (!$update) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        try {
            $user = Admin::where('email', $request->email)->first();

            if (!$user) {
                return back()->withInput()->with('error', 'User not found!');
            }

            // Hash and update the password
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete password_resets record
            DB::table('password_resets')->where(['email' => $request->email])->delete();

            Alert::toast('Your password has been successfully changed!', 'success');
            return redirect('admin/admin_login');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}