<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Wishlist;
use App\Models\Wishlist as ModelsWishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishController extends Controller
{
    public function index() {
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())->with('product')->get();
            $ecommerce_wishlist=ModelsWishlist::where('user_id',Auth::id())->with('product')->get();
        } else {
            $wishlist = session()->get('wishlist', []);
        }
        return view('Restaurant.frontend.wishlist.index', compact('wishlist','ecommerce_wishlist'));
    }

    // Add to Wishlist
    public function addToWishlist(Request $request) {
        $productId = $request->product_id;

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please log in to add to wishlist'], 401);
        }
        $wishlist = Wishlist::where('user_id', Auth::id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['added' => false]);
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);
            return response()->json(['added' => true]);
        }

        return response()->json(['success' => true, 'message' => 'Added to wishlist']);
    }

    // Remove from Wishlist
    public function removeFromWishlist(Request $request) {
        $productId = $request->product_id;

        if (Auth::check()) {
            Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->delete();
        } else {
            $wishlist = session()->get('wishlist', []);
            unset($wishlist[$productId]);
            session()->put('wishlist', $wishlist);
        }

        return response()->json(['success' => true, 'message' => 'Removed from wishlist']);
    }


    public function remove(Request $request)
    {
        $user = auth()->user();

        $wishlist = \App\Models\Wishlist::where('id', $request->id)
                    ->where('user_id', $user->id)
                    ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed']);
        }

        return response()->json(['status' => 'error'], 404);
    }



}