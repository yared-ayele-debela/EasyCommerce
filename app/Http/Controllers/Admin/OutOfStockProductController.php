<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutOfStockProductController extends Controller
{
    //
    public function index()
    {
          $vendor_id = Auth::guard('admin')->user()->vendor_id;

          $outOfStockProducts = Product::with('category','brand','group')->where('vendor_id', $vendor_id)->whereDoesntHave('attributes') // or use your custom logic
                        ->orWhereHas('attributes', function($q){
                            $q->where('stock', '<=', 0);
                     })->paginate(10);

        return view('admin.product.index', compact('outOfStockProducts'));
    }
}
