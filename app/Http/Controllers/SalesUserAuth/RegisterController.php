<?php

namespace App\Http\Controllers\SalesUserAuth;

use App\Http\Controllers\Controller;
use App\Models\SalesUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:sales');
    }

    public function showRegistrationForm()
    {
        return view('NewFrontEndPage.SalesUsers.registration');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:sales_users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return SalesUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        Auth::guard('sales')->login($user);
        
        Alert::toast('Registred successfully!','success');
        return redirect()->route('sales.dashboard');

   }
}