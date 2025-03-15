<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Models\AppSetting;
use App\Models\CmsPage;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class VendorController extends Controller
{
    //

    public function loginRegister()
    {
        try {
            $cms_pages = CmsPage::get()->toArray();
            $appsettings = AppSetting::all()->toArray();
            return view('fontend.faq');
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function Register(Request $request)
    {
        try {
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $this->validate($request, [
                'name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            $email = $request->input('email');
            $phone = $request->input('phone');

            if (strlen($request->input('phone')) !== 10) {
                Alert::toast('Phone number should be exactly 10 digits!', 'error');
                return redirect()->back();
            }
            if (Vendor::where('mobile', $phone)->exists() || Admin::where('mobile', $email)->exists()) {
                Alert::toast('Phone number already exists', 'error');
                return redirect()->back();
            }
            // Check if the email already exists in the table
            if (Vendor::where('email', $email)->exists() || Admin::where('email', $email)->exists()) {
                // Email already exists, display a message or throw an exception
                // dd($email);die;
                Alert::toast('Email already exists', 'error');

                return redirect()->back();
            }
            // dd($request->all());

            DB::beginTransaction();
            $vendor = new Vendor();
            $vendor->name = $request->input('name');
            $vendor->mobile = $request->input('phone');
            $vendor->email = $request->input('email');
            $vendor->status = 0;
            $vendor->save();


            $vendor_id = DB::getPdo()->lastInsertId();

            $admin = new Admin();
            $admin->type = 'vendor';
            $admin->vendor_id = $vendor_id;
            $admin->name = $request->input('name');
            $admin->mobile = $request->input('phone');
            $admin->email = $request->input('email');
            $admin->password = bcrypt($request->input('password'));
            $admin->status = 0;
            $admin->save();


            $email = $request->input('email');
            $email_template = EmailTemplate::first();

            $messageData = [
                'email_template' => $email_template,
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'code' => base64_encode($request->input('email')),
            ];
            Mail::send('emails.vendor_confirmation', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Confirm your Vendor Account ');
            });
            DB::commit();


            Alert::toast('Thanks for registering as Vendor. Please confirm your email to activate your account', 'success');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();

        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
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
                    $message = "Your Vendor Account is already confirmed. You can login";
                    Alert::toast($message, 'success');
                    return redirect('login_register/vendor');
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

                    Alert::toast($message, 'success');
                    return redirect('/login_register/vendor');
                }
            } else {
                abort(404);
            }
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
