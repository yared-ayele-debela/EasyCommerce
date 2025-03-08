<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Livewire\ShipppingZone;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ShippingZoneController extends Controller
{
    public function index(){
        try {

            return view('admin.shipping_zone.index')->withComponent(ShipppingZone::class);
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}