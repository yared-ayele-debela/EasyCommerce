<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VendorsController extends Controller
{
    //
    public function vendorListing($vendorid)
    {
       $vendorid = decrypt($vendorid);
    $cacheTime = now()->addMinutes(60);

    $allvendor = Cache::remember("vendor_detail_{$vendorid}", $cacheTime, function () use ($vendorid) {
        return Vendor::with('vendorbusinessdetails', 'adminvendor')->find($vendorid);
    });

    $vendorProducts = Product::with('attributes')
        ->withAvg('ratings', 'rating')
        ->with('brand')
        ->where('vendor_id', $vendorid)
        ->where('status', 1)
        ->paginate(10);

        return view('Ecommerce.vendor.detail', compact( 'allvendor', 'vendorProducts'));
    }
}
