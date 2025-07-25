<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    //
    public function index() {

        $allvendors = Vendor::with(['vendorbusinessdetails', 'adminvendor'])
        ->withCount('products')
        ->where('status', 1)
        ->where('vendor_type', 'ecommerce')
        ->inRandomOrder()
        ->paginate(12);

        $vendorRatingsCount = Rating::with('product')
            ->get()
            ->groupBy(fn($rating) => $rating->product->vendor_id ?? null)
            ->map(fn($ratings) => $ratings->count());

        return view('Ecommerce.vendor.index', compact('allvendors','vendorRatingsCount'));

    }

}