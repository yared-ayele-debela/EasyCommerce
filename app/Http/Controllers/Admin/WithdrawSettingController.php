<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Livewire\Setting\WithdrawSetting;
use Illuminate\Http\Request;

class WithdrawSettingController extends Controller
{
    //
    public function index(){

        return view('admin.withdraw_setting.index')->withComponent(WithdrawSetting::class);
    }
}