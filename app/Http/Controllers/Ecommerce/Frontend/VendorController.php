<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VendorController extends Controller
{
    //
    public function index() {

        // dd(Cache::get("allvendor_ecommerce_active"));
        $cacheTime = now()->addMinutes(60); // adjust as needed

    $allvendors = Cache::remember('allvendor_ecommerce_active', $cacheTime, function () {
        return Vendor::with(['vendorbusinessdetails', 'adminvendor'])
            ->withCount('products')
            ->where('status', 1)
            ->where('vendor_type', 'ecommerce')
            ->inRandomOrder()
            ->paginate(12);
    });

    $vendorRatingsCount = Cache::remember('vendor_ratings_count', $cacheTime, function () {
        return Rating::with('product')
            ->get()
            ->groupBy(fn($rating) => $rating->product->vendor_id ?? null)
            ->map(fn($ratings) => $ratings->count());
    });

        return view('Ecommerce.vendor.index', compact('allvendors','vendorRatingsCount'));

    }

}
