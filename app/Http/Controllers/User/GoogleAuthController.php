<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    //
    public function redirectToGoogle()
    {
        // dd("hello");
    $url = Socialite::driver('google')->redirect()->getTargetUrl();

            // dd($url); // Make sure it’s pointing to Google OAuth

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        // try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // dd($googleUser);
            // Check if the user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Register user if not exists
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'provider_id' => $googleUser->getId(),
                    'password' => bcrypt(uniqid()),
                    'status' =>1,
                ]);
            }

            // dd($user);

            Auth::login($user);

            return redirect()->intended('/my-cart');

        // } catch (Exception $e) {
        //     dd($e);
        //     return redirect('/login')->with('error', 'Something went wrong: ' . $e->getMessage());
        // }
    }
}
