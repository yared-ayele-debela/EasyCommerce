<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class OutOfStockProductController extends Controller
{
    //
    public function index()
    {
        $outOfStockProducts = Product::with('category','brand','group')->whereDoesntHave('attributes') // or use your custom logic
            ->orWhereHas('attributes', function ($q) {
                $q->where('stock', '<=', 0);
            })->paginate(10);

        return view('admin.product.index', compact('outOfStockProducts'));
    }
}
