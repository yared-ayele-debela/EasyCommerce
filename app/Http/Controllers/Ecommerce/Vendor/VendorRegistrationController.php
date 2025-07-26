<?php

namespace App\Http\Controllers\Ecommerce\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\EmailTemplate;
use App\Models\Roles;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class VendorRegistrationController extends Controller
{
    //
    public function index()
    {
        try {

            return view('auth.vendor.register');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function RegisterVendor(Request $request)
    {
        $validated = $request->validate([
        'name'     => 'required|string',
        'phone'    => 'required|string|size:10',
        'email'    => 'required|email',
        'password' => 'required|string|min:8',
    ]);

    $phone = $validated['phone'];
    $email = $validated['email'];

    // Step 2: Check if phone or email already exists
    $phoneExists = Vendor::where('mobile', $phone)->exists() || Admin::where('mobile', $phone)->exists();
    $emailExists = Vendor::where('email', $email)->exists() || Admin::where('email', $email)->exists();

    if ($phoneExists) {
        return redirect()->back()->with('error', 'Phone number already exists');
    }

    if ($emailExists) {
        return redirect()->back()->with('error', 'Email already exists');
    }

    try {
        $role=Roles::where('name', $request->input('vendor_type', 'vendor'))->first();
        if (!$role) {
            return redirect()->back()->with('error', 'Invalid vendor type selected');
        }
        // dd($role->group); // Debugging line to check the role group

        DB::beginTransaction();

        // Step 3: Create vendor
        $vendor = Vendor::create([
            'vendor_type' => $role->group, // Default to 'vendor' if not provided
            'name'    => $validated['name'],
            'mobile'  => $validated['phone'],
            'email'   => $validated['email'],
            'status'  => 1,
            'confirm' => 'Yes',
        ]);

        // Step 4: Create corresponding admin
        Admin::create([
            'type'      => $request->input('vendor_type', 'vendor'), // Default to 'vendor' if not provided
            'vendor_id' => $vendor->id,
            'name'      => $validated['name'],
            'mobile'    => $validated['phone'],
            'email'     => $validated['email'],
            'password'  => bcrypt($validated['password']),
            'status'    => 1,
            'confirm'   => 'Yes',
        ]);


        DB::commit();
        return redirect()->back()->with('success', 'Vendor registered successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
    }

    public function confirmVendor($email)
    {
        try {
            $email = base64_decode($email);
            $vendorCount = Vendor::where('email', $email)->count();
            if ($vendorCount > 0) {
                $vendorDetails = Vendor::where('email', $email)->first();
                if ($vendorDetails->confirm == "Yes") {

                    return redirect('login_register/vendor')->with('Your vendor account is already confirmed. You can login');
                } else {
                    Admin::where('email', $email)->update(['confirm' => 'Yes']);
                    Vendor::where('email', $email)->update(['confirm' => 'Yes']);
                    Admin::where('email', $email)->update(['status' => '1']);
                    Vendor::where('email', $email)->update(['status' => '1']);
                    $email_template = EmailTemplate::first();

                    $messageData = [
                        'email_template' => $email_template,
                        'email' => $email,
                        'name' => $vendorDetails['name'],
                        'mobile' => $vendorDetails->mobile,
                    ];
                    Mail::send('emails.vendor_confirmed', $messageData, function ($message) use ($email) {
                        $message->to($email)->subject('Your Vendor Account Confirmed');
                    });

                    $message = "Your Vendor Email account is confirmed. You can login and add your personal,business and bank details to activate your Vendor Account to add products ";
                    return redirect('/login_register/vendor')->with('success',$message);
                }
            } else {
                abort(404);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
}