<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AppSetting;
use App\Models\EmailTemplate;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class AdminResetController extends Controller
{
     public function ForgetPassword()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            // dd("hello");
            return view('admindashboard.forget_password.forget', compact('appsettings'));
        } catch (\Exception $e) {
            Alert::toast('Something went wrong!', 'error');
            return redirect()->back();
        }
    }

    // Handle forget password form submission
    public function ForgetPasswordStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        $email_template = EmailTemplate::first(); // Optional
        $messageData = [
            'token' => $token,
            'email' => $request->email,
            'email_template' => $email_template, // Optional for branding
        ];

        Mail::send('emails.reset-password', $messageData, function ($message) use ($request) {
            $message->to($request->email)->subject('Reset Password');
        });

        Alert::toast('We have emailed your password reset link', 'success');
        return back();
    }

    // Show the reset password form with token
    public function ResetPassword($token)
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            return view('admindashboard.forget_password.forget-password-link', compact('appsettings'), ['token' => $token]);
        } catch (\Exception $e) {
            Alert::toast('Something went wrong!', 'error');
            return redirect()->back();
        }
    }

    // Handle the reset password form submission
    public function ResetPasswordStore(Request $request)
    {
        if (!$request->isMethod('post')) {
            Alert::toast('Invalid request method!', 'error');
            return back();
        }

        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        $record = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

        if (!$record) {
            return back()->withInput()->with('error', 'Invalid or expired token!');
        }

        try {
            $admin = Admin::where('email', $request->email)->first();
            if (!$admin) {
                return back()->withInput()->with('error', 'Admin user not found!');
            }

            $admin->password = Hash::make($request->password);
            $admin->save();

            DB::table('password_resets')->where(['email' => $request->email])->delete();

            Alert::toast('Your password has been reset successfully!', 'success');
            return redirect('admin/login');
        } catch (\Exception $e) {
            Alert::toast('Something went wrong!', 'error');
            return redirect()->back();
        }
    }
}