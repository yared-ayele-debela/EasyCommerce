<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SalesUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SpecialLinkController extends Controller
{
    //
    public function handleSpecialLink($token)
    {
        $salesMan=SalesUser::where('referral_token',$token)->first();
        if($salesMan){
            session(['referral_token' => $token]);
            // dd($token);
            return redirect()->route('/');
        }else{
            abort(404);
        }

    }
}