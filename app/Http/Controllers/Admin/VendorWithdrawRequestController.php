<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Livewire\WithdrawRequest\WithdrawRequest;
use Illuminate\Http\Request;
use PDO;

class VendorWithdrawRequestController extends Controller
{
    //
    public function index(){

        return view('admin.withdraw_request.index')->withComponent(WithdrawRequest::class);
    }
}