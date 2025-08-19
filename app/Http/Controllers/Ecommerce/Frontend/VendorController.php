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
    $cacheTime = now()->addMinutes(60);
    $allvendors = Cache::remember('allvendor_ecommerce_active_' . request('page', 1), $cacheTime, function () {
        return Vendor::with(['vendorbusinessdetails', 'adminvendor'])
            ->withCount('products')
            ->where('status', 1)
            ->where('vendor_type', 'ecommerce')
            ->inRandomOrder()
            ->paginate(4);
    });

    $vendorRatingsCount = Cache::remember('vendor_ratings_count_' . request('page', 1), $cacheTime, function () {
        return Rating::with('product')
            ->get()
            ->groupBy(fn($rating) => $rating->product->vendor_id ?? null)
            ->map(fn($ratings) => $ratings->count());
    });

    return view('Ecommerce.vendor.index', compact('allvendors','vendorRatingsCount'));
}

// AJAX endpoint for load more
public function paginateAjax(Request $request)
{
    $cacheTime = now()->addMinutes(60);
    $vendors = Cache::remember('allvendor_ecommerce_active_' . $request->page, $cacheTime, function () use ($request) {
        return Vendor::with(['vendorbusinessdetails', 'adminvendor'])
            ->withCount('products')
            ->where('status', 1)
            ->where('vendor_type', 'ecommerce')
            ->inRandomOrder()
            ->paginate(4, ['*'], 'page', $request->page);
    });

    $data = [];
    foreach ($vendors as $vendor) {
        $cardHtml = view('components.vendor-card', ['vendor' => $vendor])->render();
        $data[] = $cardHtml;
    }
    return response()->json([
        'data' => $data,
        'has_more' => $vendors->hasMorePages(),
    ]);
}

}
