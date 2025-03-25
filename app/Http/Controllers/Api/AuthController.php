<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Restaurant;
use Exception;

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
     *             required={"name", "mobile", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="mobile", type="string", example="1234567890"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
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
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while registering', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/user/login",
     *     summary="User login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"phone_or_email", "password"},
     *             @OA\Property(property="phone_or_email", type="string", example="user@example.com or 1234567890"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
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
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function login(Request $request)
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
                $credentials['phone'] = $credentials['phone_or_email'];
                unset($credentials['phone_or_email']);
            }

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json(['token' => $token, 'user' => $user], 200);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while logging in', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/user/forgot-password",
     *     summary="Request password reset for user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"phone"},
     *             @OA\Property(property="phone", type="string", example="1234567890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OTP sent for password reset",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="OTP sent successfully")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function forgotPassword(Request $request)
    {
        // Handle OTP generation and sending logic here

        return response()->json(['message' => 'OTP sent successfully'], 200);
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
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function resetPassword(Request $request)
    {
        // Handle OTP verification and password reset logic here

        return response()->json(['message' => 'Password reset successfully'], 200);
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
     *             required={"restaurant_name", "phone", "password", "working_hour", "chosen_bank"},
     *             @OA\Property(property="restaurant_name", type="string", example="Pizza Palace"),
     *             @OA\Property(property="phone", type="string", example="1234567890"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="working_hour", type="string", example="9 AM - 9 PM"),
     *             @OA\Property(property="chosen_bank", type="string", example="Bank of XYZ")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful registration",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="restaurant")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function registerRestaurant(Request $request)
    {
        try {
            $request->validate([
                'restaurant_name' => 'required|string|max:255',
                'phone' => 'required|string|unique:restaurants',
                'password' => 'required|string|min:8',
                'working_hour' => 'required|string|max:255',
                'chosen_bank' => 'required|string|max:255',
            ]);

            $restaurant = Restaurant::create([
                'restaurant_name' => $request->restaurant_name,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'working_hour' => $request->working_hour,
                'chosen_bank' => $request->chosen_bank,
            ]);

            $token = $restaurant->createToken('auth_token')->plainTextToken;

            return response()->json(['token' => $token, 'restaurant' => $restaurant], 201);
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
     *             required={"phone", "password"},
     *             @OA\Property(property="phone", type="string", example="1234567890"),
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
                'phone' => 'required|string',
                'password' => 'required|string|min:8',
            ]);

            $credentials = $request->only('phone', 'password');

            if (Auth::guard('restaurant')->attempt($credentials)) {
                $restaurant = Auth::guard('restaurant')->user();
                $token = $restaurant->createToken('auth_token')->plainTextToken;

                return response()->json(['token' => $token, 'restaurant' => $restaurant], 200);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while logging in restaurant', 'details' => $e->getMessage()], 500);
        }
    }
}
