<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Restaurant\OrderConfirmationMail;
use App\Models\Bank;
use App\Models\Country;
use App\Models\Restaurant\Coupon;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\OrderItem;
use App\Models\Restaurant\OrderPaymentInfo;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\ShippingCharge;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    //

    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        session(['cart_subtotal' => $subtotal]);
        $countries = Country::all();
        $tips = Tip::all();

        // dd($cart);
        $totalTax = 0;
        $totalShipping = 0;
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) continue; // Skip if product doesn't exist
            $restaurant = Restaurant::find($product->restaurant_id);
            if (!$restaurant) continue; // Skip if restaurant not found
            $zone = $restaurant->zone;
            $weight = $item['quantity'] * $product->weight; // Assume 1kg per product, customize this as needed
            $shipping = ShippingCharge::getShippingCharges($weight, $zone);

            $totalShipping += $shipping;

            $subtotal = $product->price * $item['quantity'];
            $taxAmount = round($subtotal * ($product->product_tax / 100), 2);
            $totalTax += $taxAmount;

        }
        // dd($totalShipping);
        $banks=Bank::all();

        return view('Restaurant.frontend.checkout.index', compact('totalTax','banks','tips', 'cart', 'subtotal', 'countries','totalShipping'));
    }


    public function placeOrder(Request $request)
    {
        // dd($request->all());
        try{
        if ($request->payment_method === "manual") {
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|string',
                'address_id' => 'required|exists:delivery_address,id',
                'bank_name' => 'nullable|string|max:255',
                'transaction_number' => 'nullable|string|max:255',
                'receipt' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|string',
                'address_id' => 'required|exists:delivery_address,id',
            ]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $tipAmount = 0;
        if ($request->tip_option) {
            if (is_numeric($request->tip_option)) {
                $tipAmount = $request->tip_option;
            }
        }


        // dd($tipAmount);
        $subtotal = session()->get('cart_subtotal', 0);
        $discount = session()->get('discount', 0);
        $delivery_fee = $request->input('delivery_fee', 0);
        $total = max(($subtotal - $discount), 0) + $delivery_fee + $tipAmount;

        // dd($total);
        DB::beginTransaction();

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'delivery_fee' => $delivery_fee,
            'total' => $total,
            'tax' => $request->input('tax', 0),
            'tip_amount' => $tipAmount,
            'delivery_code' => strtoupper(Str::random(6)),
            'status' => 'pending',
            'payment_method' => $request->input('payment_method'),
            'delivery_address_id' => $request->input('address_id'),
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'size' => $item['size'] ? $item['size'] : '',
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
                'picked_code' => strtoupper(Str::random(6)),
            ]);
        }

        if ($request->payment_method === "manual") {
            $payment = new OrderPaymentInfo();
            $payment->restaurant_orders_id = $order->id;
            $payment->user_id = Auth::user()->id;
            $payment->bank_name = $request->input('bank_name');
            $payment->transaction_number = $request->input('transaction_number');
            $payment->receipt = $request->file('receipt')->store('restaurant', 'public');;
            $payment->amount_paid = $total;
            $payment->save();
        }
        // Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order));

        DB::commit();
        session()->forget(['cart', 'cart_subtotal', 'discount']); // Clear cart session after successful order

        return redirect()->route('restaurant.order.success', ['order' => $order->id])
            ->with('success', 'Your order has been placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on error
            return back()->with('error', 'Something went wrong. Please try again.')->withErrors($e->getMessage());
        }
    }

    public function orderNowPage()
    {

        $countries = Country::all();

        return view('Restaurant.frontend.checkout.order_now.index', compact('countries'));
    }

    public function orderNow(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Clear existing cart
        session()->forget(['cart', 'cart_subtotal', 'discount']); // Clear cart session after successful order

        $quantity = $request->qty;
        $price = $request->price;

        $cart = [
            $product->id => [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
                'size' => $request->size,
            ],
        ];

        // Save to session
        session([
            'cart' => $cart,
            'cart_subtotal' => $price,
            'discount' => 0, // No coupon applied yet
        ]);

        return redirect()->route('restaurant.checkout.orderNowPage');
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->coupon_code;

        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', 1)
            ->whereDate('validated_date', '>=', now())
            ->first();
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon.'], 400);
        }
        $discountAmount = $coupon->type === 'fixed'
            ? $coupon->value
            : ($coupon->value) / 100;
        session(['discount' => $discountAmount]);

        return response()->json(['success' => true]);
    }
}