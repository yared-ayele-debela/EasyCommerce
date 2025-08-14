<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

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
use App\Models\ProductAttribute;
use App\Models\Rating;
use App\Models\Vendor;
use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    //

public function index()
{
    $cacheTime = 60 * 60;

// All vendors
$allvendor = Cache::remember('allvendor_ecommerce_active', $cacheTime, function () {
    return Vendor::with(['vendorbusinessdetails', 'adminvendor'])
        ->withCount('products')
        ->where('status', 1)
        ->where('vendor_type', 'ecommerce')
        ->inRandomOrder()
        ->paginate(12);
});


// Vendor ratings count
$vendorRatingsCount = Cache::remember('vendor_ratings_count', $cacheTime, function () {
    return Rating::with('product')
        ->get()
        ->groupBy(fn($rating) => $rating->product->vendor_id ?? null)
        ->map(fn($ratings) => $ratings->count());
});

    $group = Cache::remember('group_with_categories', $cacheTime, function () {
        return Group::with('categories')->get();
    });

    $alladvertisement = Cache::remember('advertisements_approved_ecommerce', $cacheTime, function () {
        return Advertisement::where('is_approved', 1)->where('type', 'ecommerce')->get();
    });


    $getCategory = Cache::remember('top_level_categories_active', $cacheTime, function () {
        return Category::where('parent_id', 0)->where('status', 1)->get();
    });


   $isfeatured = Cache::tags(['products'])->remember('featured_products', $cacheTime, function () {
        return Product::with('attributes')->withAvg('ratings', 'rating')
            ->where('is_Featured', 'Yes')
            ->where('status', 1)
            ->inRandomOrder()
            ->get();
    });

    $new_products = Cache::tags(['products'])->remember('new_products_active', $cacheTime, function () {
        return Product::with('attributes')->where('status', 1)
            ->orderByDesc('id')
            ->get();
    });

    $discountedproduct = Cache::tags(['products'])->remember('discounted_products', $cacheTime, function () {
        return Product::with('attributes')->withAvg('ratings', 'rating')
            ->where('product_discount', '>', 0)
            ->where('status', 1)
            ->inRandomOrder()
            ->get();
    });

    $all_products = Cache::tags(['products'])->remember('all_products_active', $cacheTime, function () {
        return Product::with('attributes')->withAvg('ratings', 'rating')
            ->where('status', 1)
            ->orderByDesc('id')
            ->get();
    });

    $new_arrival = Cache::tags(['products'])->remember('new_arrival_products', $cacheTime, function () {
        return Product::with('attributes')->withAvg('ratings', 'rating')
            ->where('status', 1)
            ->latest()
            ->limit(4)
            ->get();
    });


    $banners = Cache::tags(['banners'])->remember('banners_slider_active', $cacheTime, function () {
        return Banner::where('type', 'Slider')->where('status', 1)->get();
    });

    $fixbanners = Cache::tags(['banners'])->remember('banners_fix_active', $cacheTime, function () {
        return Banner::where('type', 'Fix')->where('status', 1)->get();
    });



    $getVendorShop = Cache::remember('admin_vendors_with_business', $cacheTime, function () {
        return Admin::with('vendorBusiness')->where('type', 'vendor')->get();
    });



    $now = \Carbon\Carbon::now('UTC');
    $featured_flash_deal = Cache::tags(['products'])->remember('featured_flash_deal_active', $cacheTime, function () use ($now) {
        return FlashDeal::where('status', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->first();
    });

    $flash_deal_products = collect();
    if ($featured_flash_deal) {
        $flash_deal_products = Cache::tags(['products'])->remember('flash_deal_products_'.$featured_flash_deal->id, $cacheTime, function () use ($featured_flash_deal) {
            return FlashDealProduct::with(['product.ratings'])
                ->where('flash_deal_id', $featured_flash_deal->id)
                ->inRandomOrder()
                ->get();
        });
    }

    $allbrands = Cache::tags(['products', 'brands'])->remember('brands_active', $cacheTime, function () {
        return Brand::where('status', 1)->get()->toArray();
    });

    $page = request()->get('page', 1);
    $auto_scroll_products = Cache::tags(['products'])->remember("auto_scroll_products_page_{$page}", $cacheTime, function () {
        return Product::with('attributes')
            ->withAvg('ratings', 'rating')
            ->where('status', 1)
            ->latest()
            ->paginate(12);
    });


    $ad_after_discounted_products = Cache::remember('advert_after_discounted_products', $cacheTime, function () {
        return Advertisement::where('position', 'after_discounted_products')->where('is_approved', 1)->first();
    });

    $ad_after_featured_products = Cache::remember('advert_after_featured_products', $cacheTime, function () {
        return Advertisement::where('position', 'after_featured_products')->where('is_approved', 1)->first();
    });

    $ad_after_vendors = Cache::remember('advert_after_vendors', $cacheTime, function () {
        return Advertisement::where('position', 'after_vendors')->where('is_approved', 1)->first();
    });

    return view('all_frontend_layouts.ecommerce', compact(
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
