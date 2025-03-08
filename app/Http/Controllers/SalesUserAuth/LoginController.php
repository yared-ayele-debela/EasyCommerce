<?php

namespace App\Http\Controllers\SalesUserAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:sales')->except('logout');
    }

    public function showLoginForm()
    {
        return view('NewFrontEndPage.SalesUsers.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('sales')->attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->filled('remember')
        )) {
            return redirect()->intended(route('sales.dashboard'));
        }

        return back()->withInput($request->only('email', 'remember'))
                     ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('sales')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}