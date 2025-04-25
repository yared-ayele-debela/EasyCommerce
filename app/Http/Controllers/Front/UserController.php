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
            return view('auth.login_register', compact('appsettings', 'cms_pages'));
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
                'passwords' => 'required|min:8|confirmed',
            ]);

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
                Alert::toast('Email already exists', 'error');
                return redirect()->back();
            }
            $user = new User;
            $user->name = $request->input('name');
            $user->mobile = $request->input('mobile');
            $user->email = $request->input('emails');
            $user->password = bcrypt($request->input('passwords'));
            $user->status = 1;
            $user->save();

            // $email_template = EmailTemplate::first();
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
                'passwords' => 'required|min:6', // Minimum password length is 6 characters (you can adjust this as needed)
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['passwords']])) {
                    $id=Auth::user()->id;
                    $user=User::where('id',$id)->first();
                    if ($user->status == 0) {
                        Auth::logout();
                        return redirect()->back()->with('info', 'Your account is not activated. Please confirm your account to activate it.');
                    }
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id' => $user_id]);
                    }
                    return redirect('my-cart')->with('success', 'Welcome to our website!');
                } else {
                    return redirect()->back()->with('error', 'Incorrect username or password');
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
                return view('auth.forget_password', compact('cms_pages', 'appsettings'));
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
            $cities = City::all()->where('status', 1);
            $states = State::all()->where('status', 1);
            return view('auth.update-profile', compact('countries', 'cms_pages', 'states', 'cities', 'appsettings'));
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

    public function updatePassword(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'oldpassword' => 'required|string',
            'new_password' => ['required|string|min:8','same:new_password_confirmation'],
        ]);



        // Check if the old password matches
        if (!Hash::check($request->oldpassword, Auth::user()->password)) {
            return redirect()->back()->withErrors(['oldpassword' => 'The current password is incorrect.']);
        }

        $user=User::findOrFail(Auth::user()->id);

        // Update the password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with(['successs' => true, 'message' => 'Password updated successfully!']);
    }

    // Update Account Details
    public function updateAccountDetails(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'country' => 'required|string',
            'mobile' => 'required|numeric',
            'address' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user=User::findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->country = $request->country;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->pincode = $request->pincode;
        if ($request->hasFile('profile_image')) {
        // Get the file from the request
        $file = $request->file('profile_image');

        // Generate a unique file name
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        // Store the file in the 'public/profile_images' directory
        $filePath = $file->storeAs('public/profile_images', $fileName);
        $user->profile_photo_path= 'profile_images/'.$fileName;

        }
        $user->save();

        return redirect()->back()->with('success', 'Account details updated successfully!');
    }
}