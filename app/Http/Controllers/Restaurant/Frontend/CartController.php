<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Restaurant\Coupon;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\RestaurantCartItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //
    public function addToCart(Request $request)
    {

        // dd($request->all());
        // $cart = session()->get('cart', []);

        $cartItem=[
            'product_id' => $request->product_id,
            'size' => $request->size? $request->size : '',
            'price' => $request->price,
            'quantity' => $request->quantity
        ];
         if (Auth::check()) {
            // User is logged in, store in DB
            RestaurantCartItem::create([
                'user_id' => Auth::id(),
                ...$cartItem
            ]);
        } else {
            // Guest user, store in session
            $cart = session()->get('cart', []);
            $cart[] = $cartItem;
            session()->put('cart', $cart);
        }
        // session()->put('cart', $cart);

        return response()->json(['status' => 'success', 'message' => 'Product added to cart!']);
    }

public function updateCart($key, $action)
{
    if (Auth::check()) {
        $user_id = Auth::id();
        $cartItem = RestaurantCartItem::where('user_id', $user_id)->skip($key)->take(1)->first();

        if ($cartItem) {
            if ($action === 'increase') {
                $cartItem->quantity += 1;
                $cartItem->save();
            } elseif ($action === 'decrease') {
                if ($cartItem->quantity > 1) {
                    $cartItem->quantity -= 1;
                    $cartItem->save();
                } else {
                    $cartItem->delete(); // Remove if quantity goes to 0
                }
            }
        }

        // Recalculate subtotal
        $subtotal = RestaurantCartItem::where('user_id', $user_id)->sum(DB::raw('price * quantity'));
        session(['cart_subtotal' => $subtotal]);

        $cartCount = RestaurantCartItem::where('user_id', $user_id)->sum('quantity');

        return response()->json(['success' => true, 'cart_count' => $cartCount]);
    } else {
        // Guest user – session cart
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            if ($action == "increase") {
                $cart[$key]['quantity']++;
            } elseif ($action == "decrease" && $cart[$key]['quantity'] > 1) {
                $cart[$key]['quantity']--;
            } else {
                unset($cart[$key]); // Remove if quantity is 0 or less
            }
        }

        session()->put('cart', $cart);

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        session(['cart_subtotal' => $subtotal]);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json(['success' => true, 'cart_count' => $cartCount]);
    }
}

public function removeFromCart($key)
{
    if (Auth::check()) {
        // Authenticated user: remove item from DB
        $user_id = Auth::id();
        $cartItems = RestaurantCartItem::where('user_id', $user_id)->get();

        if (isset($cartItems[$key])) {
            $cartItems[$key]->delete();
        }

        Session::forget('discount');

        $updatedItems = RestaurantCartItem::where('user_id', $user_id)->get();
        $subtotal = $updatedItems->sum(fn($item) => $item->price * $item->quantity);
        $cartCount = $updatedItems->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => $cartCount,
            'subtotal' => $subtotal
        ]);

    } else {
        // Guest user: remove item from session
        $cart = Session::get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]); // Remove the item
            Session::put('cart', $cart);
        }

        Session::forget('discount');

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => $cartCount,
            'subtotal' => $subtotal
        ]);
    }
}




    public function viewCart()
    {
        $cart = Helper::RestaurantCartItems();

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