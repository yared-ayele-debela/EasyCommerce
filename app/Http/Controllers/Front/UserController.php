<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Auth;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\City;
use App\Models\CmsPage;
use App\Models\Country;
use App\Models\EmailTemplate;
use App\Models\State;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //
    public function loginRegister()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();
            return view('NewFrontEndPage.users.login_register', compact('appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }



    public function userRegister(Request $request)
    {
        try {
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $data = $this->validate($request, [
                'name' => 'required|string',
                'phone' => 'required|string',
                'emails' => 'required|',
                'password' => 'required|min:8',
            ]);
            // dd($data);

            $email = $request->input('emails');
            $phone = $request->input('phone');

            if (strlen($request->input('phone')) !== 10) {
                Alert::toast('Phone number should be exactly 10  digits', 'error');
                return redirect()->back();
            }
            if (User::where('mobile', $phone)->exists()) {
                Alert::toast('Phone Number already exists', 'error');
                return redirect()->back();
            }

            if (User::where('email', $email)->exists()) {
                // Email already exists, display a message or throw an exception
                // dd($email);die;
                Alert::toast('Email already exists', 'error');
                return redirect()->back();
            }
            $user = new User;
            $user->name = $request->input('name');
            $user->mobile = $request->input('mobile');
            $user->email = $request->input('emails');
            $user->password = bcrypt($request->input('password'));
            $user->status = 1;
            $user->save();
            $email_template = EmailTemplate::first();

            //Acitve the user only when user confirm his email account
            // $email = $data['emails'];
            // $messageData = [
            //     'email_template' => $email_template,
            //     'name' => $data['name'],
            //     'email' => $data['emails'],
            //     'code' => base64_encode($data['emails'])
            // ];
            // Mail::send('emails.confirmation', $messageData, function ($message) use ($email) {
            //     $message->to($email)->subject('Confirm');
            // });

            //redirect back user with success message
            Alert::toast('Thanks for registering as User. Please confirm your email to activate your account', 'success');
            // notify()->warning('Thanks for registering as User. Please confirm your email to activate your account','Not Active');
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

    public function userLogout()
    {
        try {
            Auth::logout();
            Session::flush();
            return redirect('/');
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function userLogin(Request $request)
    {
        try {
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $data = $request->all();

            $validator = Validator::make($data, [
                'email' => 'required|email|max:150|exists:users',
                'password' => 'required|min:6', // Minimum password length is 6 characters (you can adjust this as needed)
            ]);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    $id=Auth::user()->id;
                    $user=User::where('id',$id)->first();
                    if ($user->status == 0) {
                        Auth::logout();
                        Alert::toast('Your account is not activated. Please confirm your account to activate it.','info');
                        return redirect()->back();
                    }
                    // Update User Cart with user_id
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id' => $user_id]);
                    }

                    // Login successful, redirect to the cart or any other desired page
                    Alert::toast('Welcome to our website!', 'success');
                    return redirect('cart');
                } else {
                    // Login failed, redirect back with an error message
                    Alert::toast('Incorrect username or password', 'error');
                    return redirect()->back();
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function confirmAccount($code)
    {
        try {
            $email = base64_decode($code);
            $userCount = User::where('email', $email)->count();
            if ($userCount > 0) {
                $userDetails = User::where('email', $email)->first();
                if ($userDetails->status == 1) {
                    Alert::toast('Your account is already activated. You can login now !', 'success');
                    return redirect('user/login-register');
                } else {
                    User::where('email', $email)->update(['status' => 1]);
                    //send Register Email
                    $email_template = EmailTemplate::first();

                    $messageData = [
                        'email_template' => $email_template,
                        'name' => $userDetails->name, 'mobile' => $userDetails->mobile, 'email' => $email
                    ];

                    Mail::send('emails.register', $messageData, function ($message) use ($email) {
                        $message->to($email)->subject('Welcome');
                    });

                    Alert::toast('Your account is activated.you can login now !', 'success');
                    return redirect('user/login-register');
                }
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $cms_pages = CmsPage::get()->toArray();
            $appsettings = AppSetting::all()->toArray();
            if ($request->ajax()) {
                $data = $request->all();
                $validator = Validator::make(
                    $request->all(),
                    [
                        'email' => 'required|email|max:150|exists:users',

                    ],
                    [
                        'email.exists' => 'Email does not exits'
                    ]
                );
                if ($validator->fails()) {

                    return response()->json(['type' => 'error', 'errors' => $validator->errors()]);
                } else {
                    $new_password = Str::random(16);

                    User::where('email', $data['email'])->update(['password' => bcrypt($new_password)]);
                    $userDetails = User::where('email', $data['email'])->first()->toArray();

                    //Send Email to User
                    $email_template = EmailTemplate::first();

                    $email = $data['email'];
                    $messageData = [
                        'email_template' => $email_template,
                        'name' => $userDetails['name'], 'email' => $email, 'password' => $new_password
                    ];

                    Mail::send('emails.user_forget_password', $messageData, function ($message) use ($email) {
                        $message->to($email)->subject('New Password -BYT Developers');
                    });

                    return response()->json(['type' => 'success', 'message' => 'New Password sent to your registered email.']);
                }
            } else {
                return view('NewFrontEndPage.users.forget_password', compact('cms_pages', 'appsettings'));
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

    public function createuserAccount()
    {
        try {
            $cms_pages = CmsPage::get()->toArray();
            $appsettings = AppSetting::all()->toArray();
            $countries = Country::where('status', 1)->get()->toArray();
            $city = City::all()->where('status', 1);
            $state = State::all()->where('status', 1);
            return view('NewFrontEndPage.users.user_account', compact('countries', 'cms_pages', 'state', 'city', 'appsettings'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function userAccount(Request $request)
    {

        try {
            if (!$request->method('put')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $data = $request->all();
            $user = User::find($data['user_id']);
            $user->name = $data['name'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->address = $data['address'];
            $user->country = $data['country'];
            $user->mobile = $data['mobile'];
            $user->pincode = $data['pincode'];
            $user->update();
            Alert::toast('your details information is updated!', 'success');

            return redirect('user/display/user_details_account');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update_user_password(Request $request)
    {

        try {
            if (!$request->method('put')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }

            $request->validate([
                'oldpassword' => 'required',
                'new_password' => ['required'],
                'new_confirm_password' => ['same:new_password'],
            ]);
            // return $request->all();
            if (!Hash::check($request->oldpassword, Auth::user()->password)) {
                Alert::toast('your old password is not correct!', 'error');
                return back();
            }
            // Current password and new password same
            if (!strcmp($request->get('new_password'), $request->get('new_confirm_password')) == 0) {
                Alert::toast('new password and confirm password  not the same. !', 'error');
                return back();
            }
            #Update the new Password
            User::whereId(Auth::user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            Alert::toast('Password Updated Succesfully !', 'success');
            return back();
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
