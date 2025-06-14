<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Group;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class FilterProductController extends Controller
{

    public function search(){
        $groups=Group::all();
        $categories=Category::all();
        $brands=Brand::all();
        $vendors=Vendor::all();
        

        return view('Ecommerce.products.filter.index',compact('brands','categories','vendors','groups'));
    }
    public function filter(Request $request)
{
    $products = Product::query();

    // Filter by multiple group_ids
    if ($request->has('group_ids') && is_array($request->group_ids)) {
        $products->whereIn('group_id', $request->group_ids);
    }

    // Filter by multiple category_ids
    if ($request->has('category_ids') && is_array($request->category_ids)) {
        $products->whereIn('category_id', $request->category_ids);
    }

    // Filter by multiple brand_ids
    if ($request->has('brand_ids') && is_array($request->brand_ids)) {
        $products->whereIn('brand_id', $request->brand_ids);
    }

    // Filter by multiple vendor_ids
    if ($request->has('vendor_ids') && is_array($request->vendor_ids)) {
        $products->whereIn('vendor_id', $request->vendor_ids);
    }

    // Filter by discounted
    if ($request->has('discounted') && $request->discounted == 1) {
        $products->whereNotNull('product_discount')
                 ->where('product_discount', '>', 0)
                 ->whereDate('discount_start_date', '<=', now())
                 ->whereDate('discount_end_date', '>=', now());
    }

    // Filter by max_price
    if ($request->has('min_price') && $request->has('max_price') &&
    is_numeric($request->min_price) && is_numeric($request->max_price)) {
    
    $products->whereBetween('product_price', [
        $request->min_price,
        $request->max_price
    ]);

} elseif ($request->has('min_price') && is_numeric($request->min_price)) {

    $products->where('product_price', '>=', $request->min_price);

} elseif ($request->has('max_price') && is_numeric($request->max_price)) {

    $products->where('product_price', '<=', $request->max_price);
}


    // Optional: only active products
    $products->where('status', 1);

    $products = $products->paginate(20);

        if ($request->ajax()) {
        return view('Ecommerce.products.filter.product-list', compact('products'))->render();
    }

           return view('Ecommerce.products.filter.index',compact('products'));

}

}