<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Restaurant;
use Exception;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/user/register",
     *     summary="User registration",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
    *             required={"name", "mobile", "email", "password", "address", "city", "state", "country", "pincode", "latitude", "longitude"},
    *             @OA\Property(property="name", type="string", example="John Doe"),
    *             @OA\Property(property="mobile", type="string", example="1234567890"),
    *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
    *             @OA\Property(property="password", type="string", format="password", example="password123"),
    *             @OA\Property(property="address", type="string", example="123 Main Street"),
    *             @OA\Property(property="city", type="string", example="New York"),
    *             @OA\Property(property="state", type="string", example="NY"),
    *             @OA\Property(property="country", type="string", example="USA"),
    *             @OA\Property(property="pincode", type="string", example="10001"),
    *             @OA\Property(property="latitude", type="string", example="40.712776"),
    *             @OA\Property(property="longitude", type="string", example="-74.005974")
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Successful registration",
    *         @OA\JsonContent(
    *             @OA\Property(property="token", type="string"),
    *             @OA\Property(property="user")
    *         )
    *     ),
    *     @OA\Response(response=500, description="Server error")
    * )
    */
    public function register(Request $request)
    {
       try {
          $request->validate([
             'name' => 'required|string|max:255',
             'mobile' => 'required|string|unique:users',
             'email' => 'nullable|string|email|max:255|unique:users',
             'password' => 'required|string|min:8',
             'address' => 'nullable|string|max:255',
             'city' => 'nullable|string|max:255',
             'state' => 'nullable|string|max:255',
             'country' => 'nullable|string|max:255',
             'pincode' => 'nullable|string|max:255',
             'latitude' => 'nullable|string',
             'longitude' => 'nullable|string',
          ]);

          $user = User::create([
             'name' => $request->name,
             'mobile' => $request->mobile,
             'email' => $request->email,
             'password' => bcrypt($request->password),
             'address' => $request->address,
             'city' => $request->city,
             'state' => $request->state,
             'country' => $request->country,
             'pincode' => $request->pincode,
             'latitude' => $request->latitude,
             'longitude' => $request->longitude,
          ]);
          $otpResponse = $this->sendOtp(['phone'=>$request->mobile]);

                
          if ($otpResponse->acknowledge !== 'success') {
              return response()->json(['message' => 'Failed to send OTP'], 500);
          }
        //   $token = $user->createToken('auth_token')->plainTextToken;
          $otpResponse = [
              'message' => 'OTP sent successfully',
              'verificationId' => $otpResponse->response->verificationId,
          ];
          return response()->json($otpResponse);

        //   $token = $user->createToken('auth_token')->plainTextToken;

        //   return response()->json(['token' => $token, 'user' => $user], 201);
       } catch (Exception $e) {
          return response()->json(['error' => 'An error occurred while registering', 'details' => $e->getMessage()], 500);
       }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/user/login",
     *     summary="Login via email/password or phone/OTP",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(
     *                     description="Login using email and password",
     *                     required={"email", "password"},
     *                     @OA\Property(property="email", type="string", example="user@example.com"),
     *                     @OA\Property(property="password", type="string", format="password", example="secret123")
     *                 ),
     *                 @OA\Schema(
     *                     description="Login using phone only (OTP will be sent)",
     *                     required={"phone"},
     *                     @OA\Property(property="phone", type="string", example="+251936676745")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="user")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized or invalid credentials"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */

    public function login(Request $request)
    {
        try {
            // Email/password login
            if ($request->filled(['phone_or_email', 'password'])) {
                $request->validate([
                    'phone_or_email' => 'required|string',
                    'password' => 'required|string|min:6',
                ]);

                $credentials = $request->only('phone_or_email', 'password');

                if (filter_var($credentials['phone_or_email'], FILTER_VALIDATE_EMAIL)) {
                    $credentials['email'] = $credentials['phone_or_email'];
                } else {
                    $credentials['phone'] = $credentials['phone_or_email'];
                }

                unset($credentials['phone_or_email']);

                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                    $token = $user->createToken('auth_token')->plainTextToken;

                    return response()->json(['token' => $token, 'user' => $user], 200);
                }

                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // Phone/OTP login
            if ($request->filled(['phone'])) {
                $otpResponse = $this->sendOtp($request);


                if ($otpResponse->acknowledge !== 'success') {
                    return response()->json(['message' => 'Failed to send OTP'], 500);
                }

                $otpResponse = [
                    'message' => 'OTP sent successfully',
                    'verificationId' => $otpResponse->response->verificationId,
                ];
                return response()->json($otpResponse);
            }

            return response()->json(['message' => 'Missing required login fields.'], 422);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Login error',
                'details' => $e->getMessage()
            ], 500);
        }
    }


    public function sendOtp($request)
    {
        $request->validate(['phone' => 'required|string']);

        $user = User::where('mobile', $request->phone)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $response = Http::withToken(env('AFRO_SMS_API_KEY'))->get("https://api.afromessage.com/api/challenge", [
            'from' => env('AFRO_SMS_SENDER_ID'),
            'sender' => env('AFRO_SMS_SENDER_NAME'),
            'to' => $request->phone,
            'pr' => 'Welcome to EasyCommerce. Your OTP code is ',
            'ps' => 'please enter the OTP code to verify your phone number.',
            'ttl' => 300,
            'sb' => '1',            
            'sa' => '1',  
            'len' => '4',        
        ]);
        

        return $response;
    }
    /**
     * @OA\Post(
     *     path="/api/auth/user/forgot-password",
     *     summary="Request password reset for user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
    *             required={"email"},
    *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="OTP sent for password reset",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="OTP sent successfully")
    *         )
    *     ),
    *     @OA\Response(response=404, description="Email not found"),
    *     @OA\Response(response=500, description="Server error")
    * )
    */
    public function forgetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:255',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['error' => 'Email not found'], 404);
            }

            // Generate a unique token for password reset
            $token = bin2hex(random_bytes(16));

            // Save the token to the 'password_token' table
            \DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $token, 'created_at' => now()]
            );

            // Send the token via email using Laravel's Mail facade
            $this->sendOtpMail($user->email, $token);

            return response()->json(['message' => 'Password reset token sent successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while processing the request', 'details' => $e->getMessage()], 500);
        }
    }
    private function sendOtpMail($email, $token)
    {
        try {
            $details = [
                'to' => $email,
                'from' => 'afroel@gmail.com',
                'subject' => 'Password Reset OTP',
                'body' => "Your OTP for password reset is: $token"
            ];

            // \Mail::to($email)->send($details);
        } catch (Exception $e) {
            throw new Exception('Failed to send OTP email: ' . $e->getMessage());
        }
    }
    /**
     * @OA\Post(
     *     path="/api/auth/user/reset-password",
     *     summary="Reset user password",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"otp", "new_password"},
     *             @OA\Property(property="otp", type="string", example="123456"),
     *             @OA\Property(property="new_password", type="string", format="password", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password reset successfully")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid OTP"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required|string',
                'new_password' => 'required|string|min:8',
            ]);

            $passwordReset = \DB::table('password_resets')->where('token', $request->otp)->first();

            if (!$passwordReset) {
                return response()->json(['error' => 'Invalid OTP'], 400);
            }

            $user = User::where('email', $passwordReset->email)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $user->update(['password' => bcrypt($request->new_password)]);

            // Delete the used token
            \DB::table('password_resets')->where('token', $request->otp)->delete();

            return response()->json(['message' => 'Password reset successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while resetting the password', 'details' => $e->getMessage()], 500);
        }
    }

    // Restaurant registration and login methods will be similar to user registration and login

    /**
     * @OA\Post(
     *     path="/api/auth/restaurant/register",
     *     summary="Restaurant registration",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "address", "city", "country", "mobile", "email","password", "opening_time", "closing_time"},
     *             @OA\Property(property="name", type="string", example="Pizza Palace"),
     *             @OA\Property(property="description", type="string", example="Best pizza in town"),
     *             @OA\Property(property="address", type="string", example="123 Main Street"),
     *             @OA\Property(property="city", type="string", example="New York"),
     *             @OA\Property(property="state", type="string", example="NY"),
     *             @OA\Property(property="postal_code", type="string", example="10001"),
     *             @OA\Property(property="country", type="string", example="USA"),
     *             @OA\Property(property="mobile", type="string", example="1234567890"),
     *             @OA\Property(property="email", type="string", format="email", example="restaurant@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678"),
     *             @OA\Property(property="website", type="string", example="https://pizzapalace.com"),
     *             @OA\Property(property="opening_time", type="string", format="time", example="09:00:00"),
     *             @OA\Property(property="closing_time", type="string", format="time", example="21:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful registration",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="restaurant", type="object"),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function registerRestaurant(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'nullable|string|max:100',
                'postal_code' => 'nullable|string|max:20',
                'country' => 'required|string|max:100',
                'phone' => 'nullable|string|max:20',
                'email' => 'required|string|email|max:255|unique:restaurants|unique:users',
                'website' => 'nullable|string|max:255',
                'opening_time' => 'required|date_format:H:i:s',
                'closing_time' => 'required|date_format:H:i:s',
            ]);

            // Register as a restaurant
            $restaurant = Restaurant::create([
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'phone' => $request->phone,
                'email' => $request->email,
                'website' => $request->website,
                // 'opening_time' => date('H:i:s', strtotime($request->opening_time)),
                // 'closing_time' => date('H:i:s', strtotime($request->closing_time)),
            ]);

            // Register as a user
            $user = User::create([
                'name' => $request->name,
                'mobile' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['token' => $token, 'restaurant' => $restaurant, 'user' => $user], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while registering restaurant', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/restaurant/login",
     *     summary="Restaurant login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"phone_or_email", "password"},
     *             @OA\Property(property="phone_or_email", type="string", example="1234567890"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="restaurant")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function loginRestaurant(Request $request)
    {
        try {
            $request->validate([
                'phone_or_email' => 'required|string',
                'password' => 'required|string|min:8',
            ]);

            $credentials = $request->only('phone_or_email', 'password');

            if (filter_var($credentials['phone_or_email'], FILTER_VALIDATE_EMAIL)) {
                $credentials['email'] = $credentials['phone_or_email'];
                unset($credentials['phone_or_email']);
            } else {
                $credentials['mobile'] = $credentials['phone_or_email'];
                unset($credentials['phone_or_email']);
            }

            if (Auth()->attempt($credentials)) {
                $restaurant = Auth()->user();
                $token = $restaurant->createToken('auth_token')->plainTextToken;

                return response()->json(['token' => $token, 'restaurant' => $restaurant], 200);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while logging in restaurant', 'details' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Post(
 *     path="/api/user/verify-token",
 *     summary="Verify Token and Authenticate User",
 *     tags={"Auth"},
 *     @OA\Parameter(
 *         name="vc",
 *         in="query",
 *         required=true,
 *         description="Verification ID",
 *         @OA\Schema(type="string", example="54047239-7a1f-450b-bfdf-c996cb99b530")
 *     ),
 *     @OA\Parameter(
 *         name="to",
 *         in="query",
 *         required=true,
 *         description="Phone number",
 *         @OA\Schema(type="string", example="+251936676745")
 *     ),
 *     @OA\Parameter(
 *         name="code",
 *         in="query",
 *         required=true,
 *         description="Verification code",
 *         @OA\Schema(type="string", example="1889")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful verification",
 *         @OA\JsonContent(
 *             @OA\Property(property="acknowledge", type="string", example="success"),
 *             @OA\Property(property="response", type="object",
 *                 @OA\Property(property="phone", type="string", example="+251936676745"),
 *                 @OA\Property(property="code", type="string", example="1889"),
 *                 @OA\Property(property="verificationId", type="string", example="54047239-7a1f-450b-bfdf-c996cb99b530"),
 *                 @OA\Property(property="sentAt", type="string", example="2 minutes ago @ 2025-05-11 23:27:09")
 *             ),
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="New User"),
 *                 @OA\Property(property="phone", type="string", example="+251936676745")
 *             ),
 *             @OA\Property(property="access_token", type="string", example="1|XyzToken"),
 *             @OA\Property(property="token_type", type="string", example="Bearer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid verification details",
 *         @OA\JsonContent(
 *             @OA\Property(property="acknowledge", type="string", example="failed"),
 *             @OA\Property(property="message", type="string", example="Invalid verification details.")
 *         )
 *     )
 * )
 */
    public function verifyToken(Request $request)
    {
        $request->validate([
            'vc' => 'required|string',
            'to' => 'required|string',
            'code' => 'required|string',
        ]);

        // Make request to AFRO SMS verify endpoint
        $response = Http::get(config('app.afro_sms_verify_url'), [
            'vc'   => $request->vc,
            'to'   => $request->to,
            'code' => $request->code,
        ]);

        if ($response->failed() || $response->json('acknowledge') !== 'success') {
            return response()->json([
                'acknowledge' => 'failed',
                'message' => 'Invalid verification details.'
            ], 401);
        }

        $data = $response->json('response');
        
        // Find or create user
        $user = User::firstOrCreate(
            ['mobile' => $data['phone']],
            ['name' => 'New User']
        );

        // Create access token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'acknowledge' => 'success',
            'response' => $data,
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
