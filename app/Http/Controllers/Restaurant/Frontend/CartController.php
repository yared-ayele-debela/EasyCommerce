<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Restaurant\Coupon;
use App\Models\Restaurant\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function addToCart(Request $request)
    {

        $cart = session()->get('cart', []);

        $cart[] = [
            'product_id' => $request->product_id,
            'size' => $request->size,
            'price' => $request->price,
            'quantity' => $request->quantity
        ];

        session()->put('cart', $cart);



        return response()->json(['status' => 'success', 'message' => 'Product added to cart!']);
    }

    public function updateCart($key, $action)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            if ($action == "increase") {
                $cart[$key]['quantity']++;
            } elseif ($action == "decrease" && $cart[$key]['quantity'] > 1) {
                $cart[$key]['quantity']--;
            } else {
                unset($cart[$key]); // Remove if quantity is 0
            }
        }

        session()->put('cart', $cart);
        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Store the subtotal in session
        session(['cart_subtotal' => $subtotal]);

        return response()->json(['success' => true, 'cart_count' => count($cart)]);
    }

    public function removeFromCart($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]); // Remove the item from the cart
            session()->put('cart', $cart);
        }

        session()->forget('discount');


        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => count($cart),
            'subtotal' => array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart))
        ]);
    }



    public function viewCart()
    {
        $cart = session()->get('cart', []);

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Store the subtotal in session
        session(['cart_subtotal' => $subtotal]);

        $countries=Country::all();

        $getCartItems = Cart::getCartItems();

        return view('Restaurant.frontend.cart.index', compact('cart', 'subtotal','countries','getCartItems'));
    }

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity')); // Sum of all product quantities

        return response()->json(['count' => $count]);
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->coupon_code;
        $subtotal = session()->get('cart_subtotal', 0);

        if ($subtotal <= 0) {
            return response()->json(['success' => false, 'message' => 'Cart is empty.'], 400);
        }

        // Find active coupon
        $coupon = Coupon::where('code', $couponCode)
                        ->where('is_active', 1)
                        ->whereDate('validated_date', '>=', now())
                        ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon.'], 400);
        }

        // Calculate discount
        $discountAmount = $coupon->type === 'fixed'
                          ? $coupon->value
                          : ($subtotal * $coupon->value) / 100;

        $discountAmount = min($discountAmount, $subtotal); // Prevent discount from exceeding total
        $newTotal = max($subtotal - $discountAmount, 0); // Prevent negative total

        session(['discount' => $discountAmount, 'cart_total' => $newTotal]);

        return response()->json([
            'success' => true,
            'discount' => $discountAmount,
            'new_total' => $newTotal
        ]);
    }

    public function getProductSizes($id) {
        $product = Product::findOrFail($id);
        return response()->json(['sizes' => $product->sizes]);
    }


}