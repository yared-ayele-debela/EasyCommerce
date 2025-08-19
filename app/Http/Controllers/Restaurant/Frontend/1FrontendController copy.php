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
                    $cacheTime = 60 * 60; // Cache for 1 hour

                      $auto_restaurants = Cache::remember('auto_restaurants_page_1', $cacheTime, function () {
        return Restaurant::where('is_open', 1)->latest()->paginate(4);
    });
         $auto_scroll_products = Cache::tags(['restaurant_products'])->remember('restaurant_latest_products_page_' . $request->query('page', 1), $cacheTime, function () {
                return Product::where('is_active', 1)->latest()->paginate(12);
            });
        if ($request->ajax()) {


            return response()->json([
                'html' => view('all_frontend_layouts.partials.product-cards', compact('auto_scroll_products'))->render()
            ]);
        }

        return view('all_frontend_layouts.index',compact('auto_scroll_products','auto_restaurants'));
    }

    public function getBanners()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $banners = Cache::remember('slider_banners_active', $cacheTime, function () {
            return SliderBanner::where('is_active', 1)->get();
        });

        return response()->json(['banners' => $banners]);
    }

    public function getCategories()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $categories = Cache::remember('restaurant_categories_all', $cacheTime, function () {
            return Category::all()->map(function ($cat) {
                $cat->hasImage = $cat->image && Storage::disk('public')->exists($cat->image);
                return $cat;
            });
        });

        return response()->json(['categories' => $categories]);
    }

    public function getRenderedCategories()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $categories = Cache::remember('restaurant_categories_all', $cacheTime, function () {
            return Category::all()->map(function ($cat) {
                $cat->hasImage = $cat->image && Storage::disk('public')->exists($cat->image);
                return $cat;
            });
        });

        $html = '';
        foreach ($categories as $category) {
            $html .= view('components.restaurant.category-card', ['category' => $category])->render();
        }

        return response()->json(['html' => $html]);
    }

    public function getSpecialOfferProducts()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $products = Cache::tags(['restaurant_products'])->remember('restaurant_products_with_discount', $cacheTime, function () {
            return Product::where('discount', '>', 0)
                ->orderBy('discount', 'desc')
                ->get();
        });

        return response()->json(['products' => $products]);
    }

    public function getRenderedSpecialOfferProducts()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $products = Cache::tags(['restaurant_products'])->remember('restaurant_products_with_discount', $cacheTime, function () {
            return Product::where('discount', '>', 0)
                ->orderBy('discount', 'desc')
                ->get();
        });

        $html = '';
        foreach ($products as $product) {
            $html .= view('components.restaurant.product-card', ['product' => $product])->render();
        }

        return response()->json(['html' => $html]);
    }

    public function getMostPopularProducts()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $products = Cache::tags(['restaurant_products'])->remember('restaurant_most_popular_products', $cacheTime, function () {
            return Product::where('most_populer', 1)->latest()->get();
        });

        return response()->json(['products' => $products]);
    }

    public function getRenderedMostPopularProducts()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $products = Cache::tags(['restaurant_products'])->remember('restaurant_most_popular_products', $cacheTime, function () {
            return Product::where('most_populer', 1)->latest()->get();
        });

        $html = '';
        foreach ($products as $product) {
            $html .= view('components.restaurant.normal-product-card', [
                'product' => $product,
                'badge' => 'Most Popular',
                'bgColor' => 'btn-info'
            ])->render();
        }

        return response()->json(['html' => $html]);
    }

    public function getBestSellerProducts()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $products = Cache::tags(['restaurant_products'])->remember('restaurant_best_seller_products', $cacheTime, function () {
            return Product::where('best_seller', 1)->latest()->get();
        });

        return response()->json(['products' => $products]);
    }

    public function getRenderedBestSellerProducts()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $products = Cache::tags(['restaurant_products'])->remember('restaurant_best_seller_products', $cacheTime, function () {
            return Product::where('best_seller', 1)->latest()->get();
        });

        $html = '';
        foreach ($products as $product) {
            $html .= view('components.restaurant.normal-product-card', [
                'product' => $product,
                'badge' => 'Best Seller',
                'bgColor' => 'btn-warning'
            ])->render();
        }

        return response()->json(['html' => $html]);
    }

    public function getLatestProducts()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $products = Cache::remember('restaurant_latest_products', $cacheTime, function () {
            return Product::latest()->get();
        });

        return response()->json(['products' => $products]);
    }

    public function getRenderedLatestProducts()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $products = Cache::remember('restaurant_latest_products', $cacheTime, function () {
            return Product::latest()->get();
        });

        $html = '';
        foreach ($products as $product) {
            $html .= view('components.restaurant.normal-product-card', [
                'product' => $product,
                'badge' => 'Latest',
                'bgColor' => 'btn-danger'
            ])->render();
        }

        return response()->json(['html' => $html]);
    }

    public function getRestaurants(Request $request)
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $restaurants = Cache::remember('restaurants_open_page_' . $request->query('page', 1), $cacheTime, function () {
            return Restaurant::where('is_open', 1)->latest()->paginate(4);
        });

        return response()->json([
            'html' => view('all_frontend_layouts.partials.restaurant-cards', compact('restaurants'))->render()
        ]);
    }

    public function getAdvertisements()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $after_special_offer = Cache::remember('advert_after_special_offer', $cacheTime, function () {
            return Advertisement::where('position', 'after_special_offer_product_list')->where('is_approved', 1)->first();
        });

        $after_best_seller = Cache::remember('advert_after_best_seller', $cacheTime, function () {
            return Advertisement::where('position', 'after_best_seller_product_list')->where('is_approved', 1)->first();
        });

        $after_all_restaurants = Cache::remember('advert_after_all_restaurants', $cacheTime, function () {
            return Advertisement::where('position', 'after_all_restaurants')->where('is_approved', 1)->first();
        });

        return response()->json([
            'after_special_offer' => $after_special_offer,
            'after_best_seller' => $after_best_seller,
            'after_all_restaurants' => $after_all_restaurants
        ]);
    }

}
