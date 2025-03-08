<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    
    public function index(){

        return view('dashboard.login_and_registeration.login');
    }

    public function login(Request $request)
       {
           $this->validate($request, [
               'email' => 'required|email',
               'password' => 'required',
           ]);

           if (auth()->guard('admin')->attempt($request->only('email', 'password'))) {
            $user = auth()->guard('admin')->user(); // Get the authenticated user
            if ($user->status == '1') {

                Alert::toast('Welcome to your dashboard', 'success');
                return redirect()->route('dashboard');
            } else {
                Auth::logout();
                Alert::toast('Your account is not active!','warning');
                return back();
            }
        } else {
            Alert::toast('Invalid Email or Password!', 'error');
            return back();
        }
    }

    public function logout(Request $request)
       {
           auth()->guard('admin')->logout();

           $request->session()->invalidate();

           return redirect()->route('login-page');
    }

    public function update_password(){

        $user=Auth::guard('admin')->user();
        return view('dashboard.login_and_registeration.updatepassword',compact('user'));
    }

    public function update_admin_password(Request $request){

            $request->validate([
                'old_password' => 'required',
                'new_password' => ['required'],
                'new_password_confirmation' => ['same:new_password'],
            ]);

            if(!Hash::check($request->old_password, Auth::guard('admin')->user()->password)){

                Alert::toast('your old password is not correct!','info');
                return back();
            }
            // Current password and new password same
            if (!strcmp($request->get('new_password'), $request->get('new_password_confirmation')) == 0)
            {
                Alert::toast('new password and confirm password  not the same. !','info');
                return back();
            }
            #Update the new Password
            Admin::whereId(Auth::guard('admin')->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            Alert::toast('Password has been Updated Succesfully !','success');
            return back();
        }


      //forget password
      public function ForgetPassword()
      {
          try {
              return view('dashboard.forget_password.forget');
          } catch (\Exception $e) {
              // Log or handle the exception as needed
              Alert::toast('something is wrong!!', 'error');
              return redirect()->back();
          }
      }

      public function ForgetPasswordStore(Request $request)
      {
          if (!$request->isMethod('post')) {
              Alert::toast('Invalid request method!', 'error');
              return back();
          }
  
          $request->validate([
              'email' => 'required|email|exists:admins',
          ]);
  
          try {
              $token = Str::random(64);
  
              DB::table('password_resets')->updateOrInsert([
                  'email' => $request->email,
              ],
              [
                  'token' => $token,
                  'created_at' => Carbon::now()
              ]);
  
              $messageData = [
                  'token' => $token,
              ];
  
              Mail::send('dashboard.emails.forget-password',$messageData, function($message) use($request){
                  $message->to($request->email);
                  $message->subject('Reset Password');
              });

  
              Alert::toast('We have emailed your password reset link', 'success');
              return back();
          } catch (\Exception $e) {
              // Log or handle the exception as needed
              Alert::toast('something is wrong!!', 'error');
              return redirect()->back();
          }
      }

      public function ResetPassword($token)
      {
          try {
  
              return view('dashboard.forget_password.forget-password-link',['token' => $token]);
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
              return redirect()->route('login-page');
          } catch (\Illuminate\Validation\ValidationException $e) {
              // Laravel's built-in validation exception
              return redirect()->back()->withErrors($e->validator->errors())->withInput();
          } catch (\Exception $e) {
              // Log or handle the exception as needed
              Alert::toast('something is wrong!!', 'error');
              return redirect()->back();
          }
      }


       //for upate admin details
    public function updateadmindetails()
    {
        try {
            $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
            return view('dashboard.update-profile.update-profile', compact('adminDetails'));
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
  
  
              Alert::toast('Your profile details has been updated!', 'success');
              return redirect()->back();
          } catch (\Illuminate\Validation\ValidationException $e) {
              // Laravel's built-in validation exception
              return redirect()->back()->withErrors($e->validator->errors())->withInput();
          } catch (\Exception $e) {
              Alert::toast('Error', 'Something is wrong!', 'error');
              return redirect()->back();
          }
      }
      
}
