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


    $group = Cache::remember('group_with_categories', $cacheTime, function () {
        return Group::with('categories')->get();
    });

    $alladvertisement = Cache::remember('advertisements_approved_ecommerce', $cacheTime, function () {
        return Advertisement::where('is_approved', 1)->where('type', 'ecommerce')->get();
    });


    $getCategory = Cache::remember('top_level_categories_active', $cacheTime, function () {
        return Category::where('parent_id', 0)->where('status', 1)->get();
    });




    $all_products = Cache::tags(['products'])->remember('all_products_active', $cacheTime, function () {
        return Product::with('attributes')->withAvg('ratings', 'rating')
            ->where('status', 1)
            ->orderByDesc('id')
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
        'alladvertisement',
        'getCategory',
        'banners',
        'fixbanners',
        'group',
        'all_products',
        'getVendorShop',
        'featured_flash_deal',
        'flash_deal_products'
    ));
}

// CategoryController.php
public function ajaxCategories()
{
    $categories = Category::where('parent_id', 0)
                    ->where('status', 1)
                    ->get();

    // Return rendered Blade component HTML
    $html = '';
    foreach($categories as $category) {
        $html .= view('components.category-card', ['category' => $category])->render();
    }

    return response()->json(['html' => $html]);
}


public function ajaxBrands()
{
    $cacheTime = 60 * 60; // Cache for 1 hour
      $allbrands = Cache::tags(['products', 'brands'])->remember('brands_active', $cacheTime, function () {
        return Brand::where('status', 1)->get()->toArray();
    });

    // Return rendered Blade component HTML
    $html = '';
    foreach($allbrands as $brand) {
        $html .= view('components.brand-card', ['brand' => $brand])->render();
    }

    return response()->json(['html' => $html]);
}

public function ajaxVendors()
{
    $cacheTime = 60 * 60;
    $page = request()->get('page', 1);

    // All vendors
    $allvendor = Cache::remember("allvendor_ecommerce_active_page_{$page}", $cacheTime, function () {
        return Vendor::with(['vendorbusinessdetails', 'adminvendor'])
            ->withCount('products')
            ->where('status', 1)
            ->where('vendor_type', 'ecommerce')
            ->inRandomOrder()
            ->paginate(12);
    });

    // Vendor ratings count
    $vendorRatingsCount = Cache::remember('vendor_ratings_count', $cacheTime, function () {
        return Rating::selectRaw('products.vendor_id, COUNT(*) as count')
            ->join('products', 'ratings.product_id', '=', 'products.id')
            ->groupBy('products.vendor_id')
            ->pluck('count', 'vendor_id');
    });

    // Return rendered Blade component HTML
    $html = '';
    foreach($allvendor as $vendor) {
        $html .= view('components.vendor-card', [
            'vendor' => $vendor,
            'review-count' => $vendorRatingsCount[$vendor->id] ?? 0
        ])->render();
    }

    return response()->json(['html' => $html]);
}



// ProductController.php
public function ajaxFeatured()
{
    $products = Cache::tags(['products'])->remember('featured_products', 60*60, function () {
        return Product::with('attributes')->withAvg('ratings', 'rating')
            ->where('is_Featured', 'Yes')
            ->where('status', 1)
            ->inRandomOrder()
            ->get();
    });

    $html = '';
    foreach($products as $product) {
        $html .= view('components.product-card', ['product' => $product])->render();
    }

    return response()->json(['html' => $html]);
}

public function ajaxLatest()
{
    $products = Cache::tags(['products'])->remember('new_products_active', 60*60, function () {
        return Product::with('attributes')->where('status', 1)
            ->orderByDesc('id')->get();
    });

    $html = '';
    foreach($products as $product) {
        $html .= view('components.product-card', ['product' => $product])->render();
    }

    return response()->json(['html' => $html]);
}

public function ajaxDiscounted()
{
    $products = Cache::tags(['products'])->remember('discounted_products', 60*60, function () {
        return Product::with('attributes')->withAvg('ratings', 'rating')
            ->where('product_discount', '>', 0)
            ->where('status', 1)
            ->inRandomOrder()
            ->get();
    });

    $html = '';
    foreach($products as $product) {
        $html .= view('components.product-card', ['product' => $product])->render();
    }

    return response()->json(['html' => $html]);
}

}
