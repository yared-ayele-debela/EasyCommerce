<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       $user = Auth::user();

        // Check if user exists and profile fields are missing
        if ($user && empty($user->mobile)) {
            return redirect()
                ->route('user.account.update.form') // Change this to your profile edit route name
                ->with('error', 'Please complete your profile by adding mobile number.');
        }

        return $next($request);
    }
}
