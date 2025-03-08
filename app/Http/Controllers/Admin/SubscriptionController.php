<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Livewire\PricePlans;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SubscriptionController extends Controller
{
    public function index(){
    try {

        return view('admin.subscription.index')->withComponent(PricePlans::class);
    } catch (\Exception $e) {
        Alert::toast('something is wrong!!', 'error');
        return redirect()->back();
    }
}
}