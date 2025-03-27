<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantMenu;
use App\Models\Restaurant\SliderBanner;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //

    public function index()
    {

        $banners = SliderBanner::where('is_active', 1)->get();
        $categories = Category::where('is_active', 1)->get();
        $menus = RestaurantMenu::where('is_active', 1)->get();
        $products = Product::where('discount', '>', 0)
            ->orderBy('discount', 'desc')  // Order by discount in descending order
            ->get();
        $most_popular_products=Product::where('most_populer',1)->latest()->get();   
        $best_seller_products=Product::where('best_seller',1)->latest()->get(); 
        $restaurants= Restaurant::where('is_active',1)->get();
        return view('all_frontend_layouts.index', compact('banners', 'categories', 'menus', 'products','restaurants','most_popular_products','best_seller_products'));
    }
}