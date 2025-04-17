<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Coupon;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantMenu;
use App\Models\Restaurant\SliderBanner;
use App\Models\Restaurant\Subcategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $total_slider=SliderBanner::count();
        $total_category=Category::count();
        $total_subcategory=Subcategory::count();
        $total_menu=RestaurantMenu::count();
        $total_coupon=Coupon::count();
        $total_product=Product::count();
        $total_restaurant=Restaurant::count();
        $total_order=Order::count();

        $total_pending_order=Order::where('status','pending')->count();
        $total_processing_order=Order::where('status','processing')->count();
        $total_completed_order=Order::where('status','completed')->count();
        $total_canceled_order=Order::where('status','canceled')->count();

        return view('Restaurant.dashboard.index', compact('total_restaurant','total_product','total_coupon','total_menu','total_subcategory','total_category','total_slider','total_order', 'total_canceled_order','total_pending_order','total_completed_order','total_processing_order'));
    }
}
