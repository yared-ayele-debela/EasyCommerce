<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    //

    public function index(){
        $cart = session()->get('cart', []);

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        session(['cart_subtotal' => $subtotal]);
        $countries=Country::all();

        return view('Restaurant.frontend.checkout.index', compact('cart', 'subtotal','countries'));
    }
}