<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    //
    public function vendorListing($vendorid)
    {
        $vendorid = decrypt($vendorid);
        // $getVendorShop = Vendor::getVendorShop($vendorid);
        $allvendor = Vendor::with('vendorbusinessdetails', 'adminvendor')->where('id', $vendorid)->first();
        // dd($allvendor);

        $vendorProducts =Product::withAvg('ratings', 'rating')->with('brand')->where('vendor_id', $vendorid)->where('status', 1);
        $vendorProducts = $vendorProducts->paginate(10);
        // dd($vendorProducts);
        return view('Ecommerce.vendor.detail', compact( 'allvendor', 'vendorProducts'));
    }
}
