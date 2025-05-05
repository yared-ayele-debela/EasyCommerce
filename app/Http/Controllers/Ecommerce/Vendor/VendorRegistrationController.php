<?php

namespace App\Http\Controllers\Ecommerce\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\EmailTemplate;
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
        try {

            $this->validate($request, [
                'name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            $email = $request->input('email');
            $phone = $request->input('phone');

            if (strlen($request->input('phone')) !== 10) {
                return redirect()->back()->with('error','Phone number should be exactly 10 digits');
            }
            if (Vendor::where('mobile', $phone)->exists() || Admin::where('mobile', $email)->exists()) {
                return redirect()->back()->with('error','Phone number already exists');
            }
            // Check if the email already exists in the table
            if (Vendor::where('email', $email)->exists() || Admin::where('email', $email)->exists()) {
                return redirect()->back()->with('Eamil already exists');
            }
            // dd($request->all());

            DB::beginTransaction();
            $vendor = new Vendor();
            $vendor->name = $request->input('name');
            $vendor->mobile = $request->input('phone');
            $vendor->email = $request->input('email');
            $vendor->status = 1;
            $vendor->confirm="Yes";

            $vendor->save();


            $vendor_id = DB::getPdo()->lastInsertId();

            $admin = new Admin();
            $admin->type = 'vendor';
            $admin->vendor_id = $vendor_id;
            $admin->name = $request->input('name');
            $admin->mobile = $request->input('phone');
            $admin->email = $request->input('email');
            $admin->password = bcrypt($request->input('password'));
            $admin->status = 1;
            $admin->confirm="Yes";
            $admin->save();


            $email = $request->input('email');
            $email_template = EmailTemplate::first();

            // $messageData = [
            //     'email_template' => $email_template,
            //     'email' => $request->input('email'),
            //     'name' => $request->input('name'),
            //     'code' => base64_encode($request->input('email')),
            // ];
            // Mail::send('emails.vendor_confirmation', $messageData, function ($message) use ($email) {
            //     $message->to($email)->subject('Confirm your Vendor Account ');
            // });
            DB::commit();

            return redirect()->back()->with('success','Thanks for registering as Vendor. Please confirm your email to activate your account');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();

        } catch (\Exception $e) {
            // Log or handle the exception as needed
            return redirect()->back();
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