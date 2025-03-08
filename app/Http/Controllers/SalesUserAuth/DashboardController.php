<?php

namespace App\Http\Controllers\SalesUserAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){

        return view('NewFrontEndPage.SalesUsers.dashboard.dashboard');
    }
}