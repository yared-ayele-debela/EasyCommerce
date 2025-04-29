<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Restaurant\OrderConfirmationMail;
use App\Models\Country;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\OrderItem;
use App\Models\Restaurant\OrderPaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    //

    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        session(['cart_subtotal' => $subtotal]);
        $countries = Country::all();

        return view('Restaurant.frontend.checkout.index', compact('cart', 'subtotal', 'countries'));
    }


    public function placeOrder(Request $request)
    {
        if ($request->payment_method === "manual") {
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|string',
                'address_id' => 'required|exists:delivery_address,id',
                'bank_name' => 'nullable|string|max:255',
                'transaction_number' => 'nullable|string|max:255',
                'receipt' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            ]);
        } else {
            // dd("dot");
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
        $subtotal = session()->get('cart_subtotal', 0);
        $discount = session()->get('discount', 0);
        $delivery_fee = 15;
        $total = max(($subtotal - $discount), 0) + $delivery_fee;

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'delivery_fee' => $delivery_fee,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $request->input('payment_method'),
                'delivery_address_id' => $request->input('address_id'),
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

            if ($request->payment_method === "manual") {
                $payment = new OrderPaymentInfo();
                $payment->restaurant_orders_id = $order->id;
                $payment->user_id = Auth::id();
                $payment->bank_name = $request->input('bank_name');
                $payment->transaction_number = $request->input('transaction_number');
                $payment->receipt = $request->file('receipt')->store('restaurant', 'public');;
                $payment->amount_paid = $total;
                $payment->save();
            }
            Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order));

            DB::commit();
            session()->forget(['cart', 'cart_subtotal', 'discount']); // Clear cart session after successful order

            return redirect()->route('restaurant.order.success', ['order' => $order->id])
                ->with('success', 'Your order has been placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on error
            return back()->with('error', 'Something went wrong. Please try again.')->withErrors($e->getMessage());
        }
    }
}