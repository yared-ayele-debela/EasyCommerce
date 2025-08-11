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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //
    public function destroy(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/auth/login')->with('success', 'Your account has been deleted successfully.');
    }

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
        // try {
            // dd($request->all());

            $data = $this->validate($request, [
                'name' => 'required|string',
                'phone' => 'required|string',
                'emails' => 'nullable',
                'password' => 'required|min:8|confirmed',
            ]);

            $email = $request->input('emails');
            // dd($email);
            $phone = $request->input('phone');

            // if (strlen($request->input('phone')) !== 10) {
            //     return redirect()->back()->with('error', 'phone number should be exactly 10 digits');
            // }
            if (User::where('mobile', $phone)->exists()) {
                return redirect()->back()->with('error', 'phone number already exists');
            }
            // if (User::where('email', $email)->exists()) {
            //     return redirect()->back()->with('error', 'Email already exists', 'error');
            // }
            $user = new User;
            $user->name = $request->input('name');
            $user->mobile = $request->input('phone');
            $user->email = $request->input('emails');
            $user->password = bcrypt($request->input('password'));
            $user->status = 0;
            $user->save();

            $this->sendOTP($request->phone); // Send OTP here

            return redirect()->route('user-verify-otp', ['phone' => $request->phone]);

            

            return redirect()->back()->with('success', 'Your account has been created successfully! Please log in to continue.');
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     // Laravel's built-in validation exception
        //     return redirect()->back()->withErrors($e->validator->errors())->withInput();
        // } catch (\Exception $e) {
        //     // Log or handle the exception as needed

        //     return redirect()->back()->with('error', 'something was wrong');
        // }
    }
    public function showOTPVerification(Request $request)
    {
        $phone = $request->phone;
        return view('auth.otp', compact('phone'));
    }


    private function sendOTP($phone)
    {
        $ch = curl_init();
        $url = 'https://api.afromessage.com/api/challenge';
        $token = 'eyJhbGciOiJIUzI1NiJ9.eyJpZGVudGlmaWVyIjoiSHUzcFdXNHYwWmdVbU5xN2lVNXhYbWlnTEhnSEtvaHkiLCJleHAiOjE5MDQyOTkyMDIsImlhdCI6MTc0NjUzMjgwMiwianRpIjoiYjJhZTkwZmYtNGQ0Mi00NTljLWE0ZmMtMmY2OTMwNDMyNzFhIn0.pA0SxwqsaC47m-aHK7Fc2owllvBvE8DlQC3QX-tyZ1E';
        $from = 'e80ad9d8-adf3-463f-80f4-7c4b39f7f164';
        $sender = 'EASY';



        $callback = 'https://yourdomain.com/callback'; // optional, use if needed
        $to = $phone; // recipient's phone number (e.g. '2519xxxxxxxx')

        $pre = urlencode('Your OTP code is: ');  // prefix message
        $post = ''; // optional postfix, also urlencode if used
        $sb = 1; // space before
        $sa = 1; // space after
        $ttl = 300; // validity in seconds
        $len = 6; // code length
        $t = 0; // code type: 0 = number, 1 = alphanumeric

        // Step 3: Set request URL with parameters
        $requestUrl = $url . '?from=' . $from . '&sender=' . $sender . '&to=' . $to .
            '&pr=' . $pre . '&ps=' . $post . '&sb=' . $sb . '&sa=' . $sa . '&ttl=' . $ttl .
            '&len=' . $len . '&t=' . $t . '&callback=' . urlencode($callback);

        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        // Step 4: Add Authorization Header
        $headers = ['Authorization: Bearer ' . $token];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Step 5: Execute the request
        $response = curl_exec($ch);

        // Step 6: Handle Errors
        if (curl_errno($ch)) {
            // dd('cURL Error: ' . curl_error($ch));
        } else {
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch ($http_code) {
                case 200:
                    $data = json_decode($response, true);
                    if (isset($data['acknowledge']) && $data['acknowledge'] === 'success') {
                    } else {
                    }
                    break;
                default:
                    dd("Response: " . $response);
            }
        }

        // Step 7: Close cURL
        curl_close($ch);
    }

    public function verifyOTP(Request $request)
    {
        $otp = implode('', $request->otp);
        $phone = $request->phone;

        // Call Afromessage to verify OTP
        $ch = curl_init();
        $url = 'https://api.afromessage.com/api/verify';
        $token = 'eyJhbGciOiJIUzI1NiJ9.eyJpZGVudGlmaWVyIjoiSHUzcFdXNHYwWmdVbU5xN2lVNXhYbWlnTEhnSEtvaHkiLCJleHAiOjE5MDQyOTkyMDIsImlhdCI6MTc0NjUzMjgwMiwianRpIjoiYjJhZTkwZmYtNGQ0Mi00NTljLWE0ZmMtMmY2OTMwNDMyNzFhIn0.pA0SxwqsaC47m-aHK7Fc2owllvBvE8DlQC3QX-tyZ1E';

        curl_setopt($ch, CURLOPT_URL, $url . "?to=$phone&code=$otp");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        if ($data['acknowledge'] == 'success') {
            $user = User::where('mobile', $phone)->first();
            $user->status = 1;
            $user->save();

            Auth::login($user);
            return redirect()->route('my.cart.view');
        }

        return redirect()->back()->with('error', 'Invalid OTP.');
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
    // Ensure the request is POST
    if (!$request->isMethod('post')) {
        Alert::toast('Something went wrong!', 'error');
        return redirect()->back();
    }

    // Validate request
    $validator = Validator::make($request->all(), [
        'mobile' => [
            'required',
            'string',
            'max:13',
            'min:10',
            Rule::exists('users', 'mobile')
        ],
        'passwords' => 'required|string|min:6',
    ]);

    // If validation fails
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $credentials = [
        'mobile' => $request->input('mobile'),
        'password' => $request->input('passwords')
    ];
    $remember = $request->has('remember');


    // Attempt login
    if (Auth::attempt($credentials,$remember)) {
        $user = Auth::user();

        // Check if user is active
        if ($user->status == 0) {
            Auth::logout();
            return redirect()->back()
                ->with('info', 'Your account is not activated. Please confirm your account.');
        }

        // Update cart if session exists
        $sessionId = Session::get('session_id');
        if (!empty($sessionId)) {
            Cart::where('session_id', $sessionId)
                ->update(['user_id' => $user->id]);
        }

        return redirect('my-cart')->with('success', 'Welcome to our website!');
    }

    return redirect()->back()->with('error', 'Incorrect mobile number or password');
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
                        'name' => $userDetails->name,
                        'mobile' => $userDetails->mobile,
                        'email' => $email
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
                // dd($data);
                $validator = $request->validate(['identifier' => 'required|email']);

                    $new_password = Str::random(16);

                    User::where('email', operator: $data['identifier'])->update(['password' => bcrypt($new_password)]);
                    $userDetails = User::where('email', $data['identifier'])->first()->toArray();

                    //Send Email to User
                    $email_template = EmailTemplate::first();

                    $email = $data['identifier'];
                    $messageData = [
                        'email_template' => $email_template,
                        'name' => $userDetails['name'],
                        'email' => $email,
                        'password' => $new_password
                    ];

                    Mail::send('emails.user_forget_password', $messageData, function ($message) use ($email) {
                        $message->to($email)->subject('New Password -BYT Developers');
                    });

                    return response()->json(['type' => 'success', 'message' => 'New Password sent to your registered email.']);
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
            'new_password' => ['required|string|min:8', 'same:new_password_confirmation'],
        ]);
        // Check if the old password matches
        if (!Hash::check($request->oldpassword, Auth::user()->password)) {
            return redirect()->back()->withErrors(['oldpassword' => 'The current password is incorrect.']);
        }

        $user = User::findOrFail(Auth::user()->id);

        // Update the password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully!');
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

        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->country = $request->country;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->pincode = $request->pincode;
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists and not default
            if (!empty($user->profile_photo_path) && $user->profile_photo_path !== 'noimage.jpg') {
                Storage::delete('public/' . $user->profile_photo_path);
            }

            // Get the file from the request
            $file = $request->file('profile_image');

            // Generate a unique file name
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // Store the file in the 'public/profile_images' directory
            $file->storeAs('public/profile_images', $fileName);

            // Save the full image URL
            $user->profile_photo_path = asset('storage/profile_images/' . $fileName);
        }

        $user->save();

        return redirect()->back()->with('success', 'Account details updated successfully!');
    }
}