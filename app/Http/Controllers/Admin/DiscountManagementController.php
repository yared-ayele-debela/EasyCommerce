<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Livewire\ManageDiscounts;
use Illuminate\Http\Request;

class DiscountManagementController extends Controller
{
    //
    public function index(){

        return view('admin.discounts.index')->withComponent(ManageDiscounts::class);
    }
}
