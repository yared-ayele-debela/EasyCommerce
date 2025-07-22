<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AccountDeletionRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    //
    public function showDeletePage()
    {
        // Logic to handle account deletion
        // This could include validating the request, checking user permissions, etc.

        return view('all_frontend_layouts.delete_account.index');
    }



    public function sendOtp(Request $request)
    {
        $phone = $request->phone;

        $ch = curl_init();
        $url = 'https://api.afromessage.com/api/challenge';
        $token = 'eyJhbGciOiJIUzI1NiJ9.eyJpZGVudGlmaWVyIjoiSHUzcFdXNHYwWmdVbU5xN2lVNXhYbWlnTEhnSEtvaHkiLCJleHAiOjE5MDQyOTkyMDIsImlhdCI6MTc0NjUzMjgwMiwianRpIjoiYjJhZTkwZmYtNGQ0Mi00NTljLWE0ZmMtMmY2OTMwNDMyNzFhIn0.pA0SxwqsaC47m-aHK7Fc2owllvBvE8DlQC3QX-tyZ1E';
        $from = 'e80ad9d8-adf3-463f-80f4-7c4b39f7f164';
        $sender = 'EASY';

        $callback = 'https://yourdomain.com/callback'; // optional
        $pre = urlencode('Your OTP code is: ');
        $post = '';
        $sb = 1;
        $sa = 1;
        $ttl = 300; // 5 minutes
        $len = 6;
        $t = 0; // 0 = numeric

        $requestUrl = $url . '?from=' . $from . '&sender=' . $sender . '&to=' . $phone .
            '&pr=' . $pre . '&ps=' . $post . '&sb=' . $sb . '&sa=' . $sa . '&ttl=' . $ttl .
            '&len=' . $len . '&t=' . $t . '&callback=' . urlencode($callback);

        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return response()->json(['success' => false, 'message' => 'Failed to send OTP.']);
        }

        $data = json_decode($response, true);

        if (isset($data['acknowledge']) && $data['acknowledge'] === 'success') {
            return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'OTP sending failed.']);
        }
    }




    public function verifyOtp(Request $request)
    {
        $otp = $request->otp;
        $phone = $request->phone;

        $ch = curl_init();
        $url = 'https://api.afromessage.com/api/verify';
        $token = 'eyJhbGciOiJIUzI1NiJ9.eyJpZGVudGlmaWVyIjoiSHUzcFdXNHYwWmdVbU5xN2lVNXhYbWlnTEhnSEtvaHkiLCJleHAiOjE5MDQyOTkyMDIsImlhdCI6MTc0NjUzMjgwMiwianRpIjoiYjJhZTkwZmYtNGQ0Mi00NTljLWE0ZmMtMmY2OTMwNDMyNzFhIn0.pA0SxwqsaC47m-aHK7Fc2owllvBvE8DlQC3QX-tyZ1E';

        curl_setopt($ch, CURLOPT_URL, $url . "?to=$phone&code=$otp");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        return response()->json([
            'success' => isset($data['acknowledge']) && $data['acknowledge'] === 'success'
        ]);
    }


    public function deleteAccount(Request $request)
    {
        // dd($request->all());
        $request->validate(rules: [
            'reason' => 'nullable|string|max:1000',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:15',
        ]);
        $user=User::where('email', $request->email)
            ->where('mobile', $request->phone)
            ->first();
        if (!$user) {   
            return redirect()->back()->with('error', 'User not found.');
        }

        $check_if_request_already_exists = AccountDeletionRequest::where('user_email', $request->email)
            ->orWhere('user_phone', $request->phone)
            ->exists();
        if ($check_if_request_already_exists) {
            return redirect()->back()->with( 'error', 'Your deletion request already exists.');
        }
        AccountDeletionRequest::create([
            'user_email' => $request->email,
            'user_phone' => $request->phone,
            'reason' => $request->reason,
        ]);

        return redirect()->back()->with('message', 'Your deletion request has been submitted.');
    }
}