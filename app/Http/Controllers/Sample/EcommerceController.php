<?php

namespace App\Http\Controllers\Sample;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Advertisement;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\FlashDealProduct;
use App\Models\Group;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Vendor;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{
    //

    public function index()
{
    // All vendors
    $allvendor = Vendor::with(['vendorbusinessdetails', 'adminvendor'])
        ->withCount('products')
        ->where('status', 1)
        ->where('vendor_type', 'ecommerce')
        ->inRandomOrder()
        ->paginate(12);

    // Vendor ratings count
    $vendorRatingsCount = Rating::with('product')
        ->get()
        ->groupBy(fn($rating) => $rating->product->vendor_id ?? null)
        ->map(fn($ratings) => $ratings->count());

    $group = Group::with('categories')->get();

    $alladvertisement = Advertisement::where('is_approved', 1)
        ->where('type', 'ecommerce')
        ->get();

    $getCategory = Category::where('parent_id', 0)
        ->where('status', 1)
        ->get();

    $isfeatured = Product::with('attributes')->withAvg('ratings', 'rating')
        ->where('is_Featured', 'Yes')
        ->where('status', 1)
        ->inRandomOrder()
        ->get();

    $new_products = Product::with('attributes')
        ->where('status', 1)
        ->orderByDesc('id')
        ->get();

    $discountedproduct = Product::with('attributes')->withAvg('ratings', 'rating')
        ->where('product_discount', '>', 0)
        ->where('status', 1)
        ->inRandomOrder()
        ->get();

    $all_products = Product::with('attributes')->withAvg('ratings', 'rating')
        ->where('status', 1)
        ->orderByDesc('id')
        ->get();

    $new_arrival = Product::with('attributes')->withAvg('ratings', 'rating')
        ->where('status', 1)
        ->latest()
        ->limit(4)
        ->get();

    $banners = Banner::where('type', 'Slider')
        ->where('status', 1)
        ->get();

    $fixbanners = Banner::where('type', 'Fix')
        ->where('status', 1)
        ->get();

    $getVendorShop = Admin::with('vendorBusiness')
        ->where('type', 'vendor')
        ->get();

    $now = \Carbon\Carbon::now('UTC');
    $featured_flash_deal = FlashDeal::where('status', 1)
        ->where('start_date', '<=', $now)
        ->where('end_date', '>=', $now)
        ->first();

    $flash_deal_products = collect();
    if ($featured_flash_deal) {
        $flash_deal_products = FlashDealProduct::with(['product.ratings'])
            ->where('flash_deal_id', $featured_flash_deal->id)
            ->inRandomOrder()
            ->get();
    }

    $allbrands = Brand::where('status', 1)->get()->toArray();

    $page = request()->get('page', 1);
    $auto_scroll_products = Product::with('attributes')
        ->withAvg('ratings', 'rating')
        ->where('status', 1)
        ->latest()
        ->paginate(12);

    $ad_after_discounted_products = Advertisement::where('position', 'after_discounted_products')
        ->where('is_approved', 1)
        ->first();

    $ad_after_featured_products = Advertisement::where('position', 'after_featured_products')
        ->where('is_approved', 1)
        ->first();

    $ad_after_vendors = Advertisement::where('position', 'after_vendors')
        ->where('is_approved', 1)
        ->first();

    return view('aaa.ecommerce', compact(
        'ad_after_vendors',
        'ad_after_featured_products',
        'ad_after_discounted_products',
        'auto_scroll_products',
        'allbrands',
        'new_arrival',
        'alladvertisement',
        'getCategory',
        'isfeatured',
        'discountedproduct',
        'banners',
        'fixbanners',
        'group',
        'new_products',
        'all_products',
        'getVendorShop',
        'allvendor',
        'vendorRatingsCount',
        'featured_flash_deal',
        'flash_deal_products'
    ));
}

}
