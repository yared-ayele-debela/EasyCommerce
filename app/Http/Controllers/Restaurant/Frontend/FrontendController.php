<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantMenu;
use App\Models\Restaurant\SliderBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
    //

    public function index(Request $request)
    {

        $cacheTime= 60 * 60; // Cache for 1 hour
         $banners = Cache::remember('slider_banners_active', $cacheTime, function () {
        return SliderBanner::where('is_active', 1)->get();
    });

    $categories = Cache::remember('restaurant_categories_all', $cacheTime, function () {
        return Category::all()->map(function ($cat) {
            $cat->hasImage = $cat->image && Storage::disk('public')->exists($cat->image);
            return $cat;
        });
    });

    $menus = Cache::remember('restaurant_menus_active', $cacheTime, function () {
        return RestaurantMenu::where('is_active', 1)->get();
    });

    $products = Cache::tags(['restaurant_products'])->remember('restaurant_products_with_discount', $cacheTime, function () {
    return Product::where('discount', '>', 0)
        ->orderBy('discount', 'desc')
        ->get();
    });

    $most_popular_products = Cache::tags(['restaurant_products'])->remember('restaurant_most_popular_products', $cacheTime, function () {
        return Product::where('most_populer', 1)->latest()->get();
    });

    $best_seller_products = Cache::tags(['restaurant_products'])->remember('restaurant_best_seller_products', $cacheTime, function () {
        return Product::where('best_seller', 1)->latest()->get();
    });

    $latest_products = Cache::remember('restaurant_latest_products', $cacheTime, function () {
        return Product::latest()->get();
    });


    $restaurants = Cache::remember('restaurants_open', $cacheTime, function () {
        return Restaurant::where('is_open', 1)->get();
    });

    // Pagination with cache is trickier; cache page 1 only here
    $auto_restaurants = Cache::remember('auto_restaurants_page_1', $cacheTime, function () {
        return Restaurant::where('is_open', 1)->latest()->paginate(4);
    });

    $auto_scroll_products = Cache::tags(['restaurant_products'])->remember('restaurant_latest_products', now()->addMinutes(10), function () {
        return Product::where('is_active', 1)->latest()->paginate(12);
    });

    if ($request->ajax()) {
        return view('all_frontend_layouts.partials.product-cards', compact('auto_scroll_products'))->render();
    }

    $after_special_offer_product_list = Cache::remember('advert_after_special_offer', $cacheTime, function () {
        return Advertisement::where('position', 'after_special_offer_product_list')->where('is_approved', 1)->first();
    });

    $after_best_seller_product_list = Cache::remember('advert_after_best_seller', $cacheTime, function () {
        return Advertisement::where('position', 'after_best_seller_product_list')->where('is_approved', 1)->first();
    });

    $after_all_restaurants = Cache::remember('advert_after_all_restaurants', $cacheTime, function () {
        return Advertisement::where('position', 'after_all_restaurants')->where('is_approved', 1)->first();
    });

        return view('all_frontend_layouts.index', compact('banners', 'categories', 'menus','auto_restaurants', 'products','restaurants','most_popular_products','auto_scroll_products','best_seller_products','latest_products','after_special_offer_product_list','after_best_seller_product_list','after_all_restaurants'));
    }
}
