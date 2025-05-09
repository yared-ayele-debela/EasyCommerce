<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OutOfStockRequest;
use App\Models\Product;
use App\Models\Vendor;
use App\Notifications\OutOfStockRequestedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductRequestController extends Controller
{
    //
    public function store(Request $request, Product $product) {
        $request->validate(['message' => 'nullable|string|max:500']);

        $product=Product::where('id',$product->id)->first();

        $out_stock= New OutOfStockRequest();
        $out_stock->product_id=$product->id;
        $out_stock->customer_id= Auth::user()->id;
        $out_stock->vendor_id=$product->vendor_id;
        $out_stock->message=$request->message;
        $out_stock->save();

        return back()->with('success', 'Request sent to vendor successfully.');
    }
}
