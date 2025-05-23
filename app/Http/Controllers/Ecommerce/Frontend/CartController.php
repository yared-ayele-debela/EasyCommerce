<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    //
    public function index(){
        $getCartItems = Cart::getCartItems();

        return view('Ecommerce.cart.index',compact('getCartItems'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'size' => 'nullable|string',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 422);
            }

            return redirect()->back()->withErrors($validator);
        }

        // Forget the coupon sessions
        Session::forget('couponAmount');
        Session::forget('couponCode');

        if (!empty($data['size'])) {
        $getProductStock = ProductAttribute::isStokAvailable($data['product_id'], $data['size']);
        if ($getProductStock < $data['quantity']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Required quantity is not available!'
            ]);
        }
       }

        $session_id = Session::get('session_id');
        if (empty($session_id)) {
            $session_id = Session::getId();
            Session::put('session_id', $session_id);
        }

         if (Auth::check()) {
            $user_id = Auth::user()->id;
                $query = [
                    'product_id' => $data['product_id'],
                    'user_id' => $user_id
                ];
            } else {
                $user_id = 0;
                $query = [
                    'product_id' => $data['product_id'],
                    'session_id' => $session_id
                ];
            }

            // Add size conditionally to query
            if (!empty($data['size'])) {
                $query['size'] = $data['size'];
            } else {
                $query['size'] = null;
            }
        $countProducts = Cart::where($query)->count();

        if ($countProducts > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product already exists in cart!'
            ]);
        }

        $item = new Cart();
        $item->session_id = $session_id;
        $item->user_id = $user_id;
        $item->product_id = $data['product_id'];
        $item->size = $data['size'] ?? null;
        $item->quantity = $data['quantity'];
        $item->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart!'
        ]);
    }
}
