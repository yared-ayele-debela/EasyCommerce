<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\DeliveryAddress;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryAddressController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $addresses = DeliveryAddress::where('user_id', $user_id)->get();
        $countries= Country::all();
        $cities = City::all();
        $states=State::all();
        return view('auth.delivery_address.index', compact('addresses', 'countries', 'cities', 'states'));
    }

    // Delete an address
    public function destroy($id)
    {
        $address = DeliveryAddress::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $address->delete();

        return redirect()->back()->with('success', 'Address deleted successfully.');
    }
}