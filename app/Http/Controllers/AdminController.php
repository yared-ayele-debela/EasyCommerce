<?php

namespace App\Http\Controllers;

use App\Livewire\Admin\AdminList;
use App\Models\Admin;
use App\Models\AdminsRole;
use App\Models\AppSetting;
use Illuminate\Support\Str;
use App\Models\CmsPage;
use App\Models\Country;
use App\Models\Delivery_Zone;
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
            $admin = Auth::guard('admin')->user();

            if ($admin->type === 'Super Admin') {
                return view('admin.auth.updateadminpassword', compact('adminDetails'));
            } elseif ($admin->type === 'Hotel Manager') {
                return view('Hotel.dashboard.admin.updateadminpassword', compact('adminDetails'));
            } elseif ($admin->type === 'Restaurant Manager') {
                return view('Restaurant.dashboard.admin.updateadminpassword', compact('adminDetails'));
            }

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

            $admin = Auth::guard('admin')->user();

            if ($admin->type === 'Super Admin') {
                return view('admin.auth.updateadmindetails', compact('adminDetails'));
            } elseif ($admin->type === 'Hotel Manager') {
                return view('Hotel.dashboard.admin.updateadmindetails', compact('adminDetails'));
            } elseif ($admin->type === 'Restaurant Manager') {
                return view('Restaurant.dashboard.admin.updateadmindetails', compact('adminDetails'));
            }

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
                // Delete old image if not default
                if (!empty($admin->image) && $admin->image !== 'noimage.jpg') {
                    Storage::delete('public/admin/image/' . basename($admin->image)); // handles full URLs
                }

                // Generate new file name
                $file = $request->file('image');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                // Store image
                $file->storeAs('public/admin/image', $fileNameToStore);

                // Save full URL
                $admin->image = asset('storage/admin/image/' . $fileNameToStore);
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
    if (!$request->isMethod('post')) {
        Alert::toast('Error', 'Something is wrong!', 'error');
        return redirect()->back();
    }

    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    if (Auth::guard('admin')->attempt([
        'email' => $request->email,
        'password' => $request->password,
        'status' => 1
    ])){
        $user = Auth::guard('admin')->user();

        if ($user->type === "vendor" && $user->confirm === "No") {
            Auth::guard('admin')->logout();
            return redirect()->back()->with('error', 'Please confirm your email to activate your Vendor account.');
        }

        if ($user->type !== "vendor" && $user->status == "0") {
            Auth::guard('admin')->logout();
            return redirect()->back()->with('error', 'Your account is not active.');
        }

        // if($user->type === '') {
        //     Auth::guard('admin')->logout();
        // }
        // dd($user->type?? 'No type found');
        if ($user->type === 'Hotel Manager') {
            return redirect('/admin/hotel/dashboard');
        } elseif ($user->type === 'Restaurant Manager') {
            return redirect('/admin/restaurant/dashboard');
        } elseif (
            $user->type === 'Ecommerce Manager' ||
            $user->type === 'Super Admin' ||
            $user->type === 'vendor' ||
            $user->type === 'admin'

        ) {
        } elseif ($user->type !== null) {
            return redirect('/admin/dashboard');
        }

        $formattedDateTime = now()->toDateTimeString();
        ActivityLogger::log('User login', "User logged in at {$formattedDateTime}");
        return redirect('/admin/dashboard');

    } else {
        return redirect()->back()->with('error', 'Your email or password is incorrect');
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

            return redirect()->route('admin_login');
            // return view('admin.auth.login', compact('appsettings'));
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
            $zones=Delivery_Zone::all();
            return view('admin.vendor.updatevendordetails', compact('zones','vendorDetails', 'country', 'appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            Alert::toast(title:  'Something is wrong!', icon: 'error');
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
            // dd($data);
            if ($request->hasFile('vendor_image')) {
                $admin = Auth::guard('admin')->user();

                // Delete old image if not default
                if (!empty($admin->image) && $admin->image !== 'noimage.jpg') {
                    Storage::delete('public/admin/image/' . $admin->image);
                }

                // Get uploaded file
                $file = $request->file('vendor_image');
                $fileNameWithExt = $file->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                // Store the file
                $file->storeAs('public/admin/image', $fileNameToStore);

                // Option 1: Store just filename
                // Admin::where('id', $admin->id)->update([
                //     'image' => $fileNameToStore
                // ]);

                // ✅ Option 2: Store full image URL
                Admin::where('id', $admin->id)->update([
                    'image' => asset('storage/admin/image/' . $fileNameToStore)
                ]);
            }


            Admin::where('id', Auth::guard('admin')->user()->id)->update([
                'name' => $data['vendor_name'],
                'mobile' => $data['vendor_mobile']
            ]);


            Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->update([
                'name' => $data['vendor_name'],
                'mobile' => $data['vendor_mobile'],
                'city' => $data['vendor_city'],
                'state' => $data['vendor_state'],
                'address' => $data['vendor_address'],
                'country' => $data['vendor_country'],
                'pincode' => $data['vendor_pincode'],
                'zone' =>  $data['zone'],
            ]);
            ActivityLogger::log('Update detail', "user updated their detail information");


            Alert::toast('Update vendor details successfully!', 'success');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast( 'Something is wrong!', 'error');
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
        } catch (\Exception $e) {
            Alert::toast('Error', 'Something is wrong!', 'error');
            return redirect()->back();
        }
    }

    public function update_vendor_businessdetails(Request $request)
    {
        // try {
        if (!$request->method('put')) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }

        $data = $request->all();
        $vendorId = Auth::guard('admin')->user()->vendor_id;
        $vendor = VendorBussinessDetails::where('vendor_id', $vendorId)->first();

        $addressProofImage = '';
        $shopImage = '';

        // Address Proof Image Handling
        // Address Proof Image
        if ($request->hasFile('address_proof_image')) {
            if ($vendor && $vendor->address_proof_image) {
                Storage::delete('public/admin/image/' . $vendor->address_proof_image);
            }

            $file = $request->file('address_proof_image');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/admin/image', $fileName);

            // Save full public URL
            $addressProofImage = Storage::url('admin/image/' . $fileName);
        } elseif (!empty($data['current_address_proof'])) {
            $addressProofImage = $data['current_address_proof'];
        }

        // Shop Image
        if ($request->hasFile('shop_image')) {
            if ($vendor && $vendor->shop_image) {
                Storage::delete('public/admin/image/' . $vendor->shop_image);
            }

            $file = $request->file('shop_image');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/admin/image', $fileName);

            // Save full public URL
            $shopImage = Storage::url('admin/image/' . $fileName);
        } elseif (!empty($data['current_shop_image'])) {
            $shopImage = $data['current_shop_image'];
        }


        // Prepare common data
        $vendorData = [
            'vendor_id' => $vendorId,
            'address_proof_image' => $addressProofImage,
            'shop_image' => $shopImage,
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
        ];

        // Insert or Update
        if ($vendor) {
            VendorBussinessDetails::where('vendor_id', $vendorId)->update($vendorData);
        } else {
            VendorBussinessDetails::create($vendorData);
        }

        ActivityLogger::log('Update', "Updated vendor business details");

        Alert::toast('Upated vendor business details Successfully!', 'success');
        return redirect()->back();
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     // Laravel's built-in validation exception
        //     return redirect()->back()->withErrors($e->validator->errors())->withInput();
        // } catch (\Exception $e) {
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
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

     public function updatePassword(Request $request, $id)
    {
        // dd($request->password);
        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = Admin::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        Alert::toast('Admin password updated successfully!', 'success');
        return redirect()->back();
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

            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|unique:admins,email',
                'mobile' => 'required|unique:admins,mobile',
                'password' => 'required|string|min:6',
            ]);

            $role = Roles::where('name',$request->type)->first();
            // dd($role);
            // List of types that require vendor creation
            $typesWithVendors = ['vendor', 'ecommerce manager', 'hotel manager', 'restaurant manager'];

            $vendorId = null;

            if (in_array(strtolower($request->input('type')), $typesWithVendors)) {
                // Create vendor
                // dd('vendor');
                $vendor = new Vendor();
                $vendor->name = $request->input('name');
                $vendor->mobile = $request->input('mobile');
                $vendor->email = $request->input('email');
                $vendor->status = 1; // default active
                $vendor->confirm="Yes";
                $vendor->save();

                $vendorId = $vendor->id;
            }
            // dd("admin");

            // Create admin
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->type = $request->input('type');
            $admin->email = $request->input('email');
            $admin->mobile = $request->input('mobile');
            $admin->vendor_id = $vendorId;
            $admin->password = Hash::make($request->input('password'));
            $admin->status=1;
            $admin->confirm="Yes";

             if ($request->hasFile('image')) {
                // Store image and get relative path
                $path = $request->file('image')->store('admin/image', 'public');
                // Convert to full URL
                $admin->image = asset('storage/' . $path);
            }
            $admin->save();

            $admin->roles()->sync([$role->id]);


            ActivityLogger::log('Create', 'Create admin user');
            Alert::toast('Admin has been created!', 'success');
            return redirect()->route('alladmins');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('Something is wrong!', 'error');
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

           $admin = Admin::findOrFail($request->id);
        //    dd($admin);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:admins,email,' . $admin->id,
            'mobile' => 'required|unique:admins,mobile,' . $admin->id,
            'password' => 'nullable|string|min:6',
        ]);

        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->mobile = $request->input('mobile');
        $admin->type = $request->input('type');

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->input('password'));
        }

        // Image update
         if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($admin->image) {
                    $oldImagePath = str_replace(asset('storage') . '/', '', $admin->image);
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                }

                // Store new image
                $path = $request->file('image')->store('admin/image', 'public');
                $admin->image = asset('storage/' . $path); // Save full URL
        }

        $typesWithVendors = ['vendor', 'ecommerce manager', 'hotel manager', 'restaurant manager'];

        if (in_array(strtolower($request->input('type')), $typesWithVendors)) {
            if ($admin->vendor_id) {

                $vendor = Vendor::find($admin->vendor_id);
                if ($vendor) {
                    $vendor->name = $request->input('name');
                    $vendor->mobile = $request->input('mobile');
                    $vendor->email = $request->input('email');
                    $vendor->save();
                }
            } else {
                // Create new vendor
                $vendor = new Vendor();
                $vendor->name = $request->input('name');
                $vendor->mobile = $request->input('mobile');
                $vendor->email = $request->input('email');
                $vendor->status = 1;
                 $vendor->confirm="Yes";
                $vendor->save();

                $admin->vendor_id = $vendor->id;
            }
        } else {
            // Remove vendor link if not applicable anymore
            $admin->vendor_id = null;
        }

        $admin->save();

        ActivityLogger::log('Update', "Updated admin user: {$admin->name}");
        Alert::toast('Admin has been updated!', 'success');
        return redirect()->route('alladmins');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }



    public function ForgetPassword()
    {
        // try {
            $appsettings = AppSetting::all()->toArray();

            return view('admin.forget_password.forget', compact('appsettings'));
        // } catch (\Exception $e) {
        //     // Log or handle the exception as needed
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
    }
    public function ForgetPasswordStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins',
        ]);

        // try {
        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            [
                'email' => $request->email,
            ],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        $email_template = EmailTemplate::first();
        $messageData = [
            'token' => $token,
            'email_template' => $email_template,
        ];

        Mail::send('emails.reset-password', $messageData, function ($message) use ($request) {
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
            return view('admin.forget_password.forget-password-link', compact('appsettings'), ['token' => $token]);
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
