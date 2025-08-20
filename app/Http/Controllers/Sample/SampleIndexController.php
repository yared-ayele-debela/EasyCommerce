<?php

namespace App\Http\Controllers\Sample;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\HotelSlider;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\SliderBanner;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SampleIndexController extends Controller
{
    //
    public function index(Request $request)
    {
        $banners = SliderBanner::where('is_active', 1)->get();

        $categories = Category::all()->map(function ($cat) {
            $cat->hasImage = $cat->image && Storage::disk('public')->exists($cat->image);
            return $cat;
        });

        $menus = Restaurant::where('is_open', 1)->get();

        $products = Product::where('discount', '>', 0)
            ->orderBy('discount', 'desc')
            ->get();

        $most_popular_products = Product::where('most_populer', 1)
            ->latest()
            ->get();

        $best_seller_products = Product::where('best_seller', 1)
            ->latest()
            ->get();

        $latest_products = Product::latest()->get();

        $restaurants = Restaurant::where('is_open', 1)->get();

        $auto_restaurants = Restaurant::where('is_open', 1)->latest()->paginate(4);

        $auto_scroll_products = Product::where('is_active', 1)->latest()->paginate(6);

        if ($request->ajax()) {
            return view('aaa.partials.product-cards', compact('auto_scroll_products'))->render();
        }

        $after_special_offer_product_list = Advertisement::where('position', 'after_special_offer_product_list')
            ->where('is_approved', 1)
            ->first();

        $after_best_seller_product_list = Advertisement::where('position', 'after_best_seller_product_list')
            ->where('is_approved', 1)
            ->first();

        $after_all_restaurants = Advertisement::where('position', 'after_all_restaurants')
            ->where('is_approved', 1)
            ->first();

        return view('aaa.restaurant', compact(
            'banners',
            'categories',
            'menus',
            'auto_restaurants',
            'products',
            'restaurants',
            'most_popular_products',
            'auto_scroll_products',
            'best_seller_products',
            'latest_products',
            'after_special_offer_product_list',
            'after_best_seller_product_list',
            'after_all_restaurants'
        ));
    }


    public function hotel(){



        $banners = HotelSlider::where('is_active', 1)->latest()->get();

        $categories = HotelCategory::latest()->get();

        $rooms = Room::where('is_available', 1)->latest()->get();

        $discounted_hotels = Hotel::where('discount', '>', 0)->latest()->get();

        $hotels = Hotel::where('is_active', 1)->latest()->get();

        $after_discount_hotels = Advertisement::where('position', 'after_discount_hotels')
            ->where('is_approved', 1)
            ->first();

        $after_latest_rooms = Advertisement::where('position', 'after_latest_rooms')
            ->where('is_approved', 1)
            ->first();

        $after_latest_hotels = Advertisement::where('position', 'after_latest_hotels')
            ->where('is_approved', 1)
            ->first();


        return view('aaa.hotel', compact('banners', 'categories', 'hotels', 'rooms', 'discounted_hotels',  'after_discount_hotels', 'after_latest_rooms', 'after_latest_hotels'));

    }

}
