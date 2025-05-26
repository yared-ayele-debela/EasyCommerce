<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    //
    public function sendOTPForReset(Request $request)
    {
        $request->validate(rules: ['identifier' => 'required']);
        $user = User::where('mobile', operator: $request->identifier)->first();

        if (!$user) {
            return back()->with('error', 'identifier number not found.');
        }

        $this->sendOTP($request->identifier); // same sendOTP() from registration
        session(['reset_phone' => $request->identifier]); // store temporarily
        return redirect()->route('forgot.verify.form');
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
                        // dd("✅ OTP Sent Successfully!");
                    } else {
                        // dd("❌ API failure: ");
                        // dd($data);
                    }
                    break;
                default:
                    dd("Response: " . $response);
            }
        }

        // Step 7: Close cURL
        curl_close($ch);
    }

    public function verifyResetOTP(Request $request)
    {
        $otp = implode('', $request->otp);
        $phone = session('reset_phone');

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
            session(['verified_phone' => $phone]);
            return redirect()->route('reset.password.form');
        }

        return back()->with('error', 'Invalid OTP.');
    }

    public function showOTPVerifyForm(){

        return view('auth.forget.verify-otp');
    }

    public function showResetPasswordForm()
    {
        return view('auth.forget.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $phone = session('verified_phone');
        $user = User::where('mobile', $phone)->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $user->password = bcrypt($request->password);
        $user->save();

        session()->forget(['reset_phone', 'verified_phone']);
        return redirect()->route('auth.login')->with('success', 'Password reset successfully!');
    }
}
