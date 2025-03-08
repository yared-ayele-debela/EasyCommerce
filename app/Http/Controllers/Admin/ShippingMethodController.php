<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Livewire\ShipppingMethod;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ShippingMethodController extends Controller
{
    public function index(){
        try {

            return view('admin.shipping_method.index')->withComponent(ShipppingMethod::class);
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}