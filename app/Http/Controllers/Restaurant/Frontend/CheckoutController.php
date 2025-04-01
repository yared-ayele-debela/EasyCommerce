<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //

    public function index(){
        $cart = session()->get('cart', []);

        // Calculate subtotal
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        session(['cart_subtotal' => $subtotal]);

        $countries = Country::all();

        return view('Restaurant.frontend.checkout.index', compact('cart', 'subtotal', 'countries'));
    }


    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }
        $subtotal = session('cart_subtotal', 0);
        $discount = session('discount', 0);
        $delivery_fee = 15;
        $total = max(($subtotal - $discount), 0) + $delivery_fee;

        $order = Order::create([
            'user_id' => Auth::id(),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'delivery_fee' => $delivery_fee,
            'total' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'delivery_address_id' => $request->address_id,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'size' => $item['size'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget(['cart', 'discount', 'cart_subtotal']);

        return redirect()->route('restaurant.order.success', ['order' => $order->id])
            ->with('success', 'Your order has been placed successfully.');
    }
}
