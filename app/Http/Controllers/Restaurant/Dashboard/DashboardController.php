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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $total_slider = SliderBanner::count();
        $total_category = Category::count();
        $total_subcategory = Subcategory::count();
        $total_menu = RestaurantMenu::count();
        $total_coupon = Coupon::count();
        $total_product = Product::count();
        $total_restaurant = Restaurant::count();
        $total_order = Order::count();

        $total_pending_order = Order::where('status', 'pending')->count();
        $total_processing_order = Order::where('status', 'processing')->count();
        $total_completed_order = Order::where('status', 'completed')->count();
        $total_canceled_order = Order::where('status', 'canceled')->count();


        return view('Restaurant.dashboard.index', compact('total_restaurant', 'total_product', 'total_coupon', 'total_menu', 'total_subcategory', 'total_category', 'total_slider', 'total_order', 'total_canceled_order', 'total_pending_order', 'total_completed_order', 'total_processing_order'));
    }

    public function orderTrend(Request $request)
    {
        $days = in_array((int) $request->days, [7, 15, 30, 60, 90, 365]) ? (int) $request->days : 7;

        $startDate = \Carbon\Carbon::now()->subDays($days)->startOfDay();

        $orders = DB::table('restaurant_orders')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as order_count, SUM(total) as total_sales')
            ->where('created_at', '>=', $startDate)
            ->where('status', 'completed') // Optional filter
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($orders);
    }
    public function ordersByCategory(Request $request)
    {
        // Default period: Last 7 days, can be overridden by request
        $days = in_array((int)$request->days, [7, 15, 30, 60, 90, 365]) ? (int)$request->days : 7;

        $startDate = \Carbon\Carbon::now()->subDays($days)->startOfDay();
        $endDate = \Carbon\Carbon::now()->endOfDay();

        $orderData = DB::table('restaurant_order_items')
            ->join('restaurant_products', 'restaurant_order_items.product_id', '=', 'restaurant_products.id')
            ->join('restaurant_subcategories', 'restaurant_products.subcategory_id', '=', 'restaurant_subcategories.id')
            ->join('restaurant_categories', 'restaurant_subcategories.category_id', '=', 'restaurant_categories.id')
            ->whereBetween('restaurant_order_items.created_at', [$startDate, $endDate])
            ->selectRaw('restaurant_categories.name as category_name, COUNT(restaurant_order_items.id) as order_count')
            ->groupBy('category_name')
            ->orderByDesc('order_count')
            ->get();
        return response()->json($orderData);
    }

    public function topOrderingUsers(Request $request)
    {
        $days = in_array((int)$request->days, [7, 15, 30, 60, 90, 365]) ? (int)$request->days : 7;

        $startDate = \Carbon\Carbon::now()->subDays($days)->startOfDay();
        $endDate = \Carbon\Carbon::now()->endOfDay();

        $topUsers = DB::table('restaurant_orders')
            ->join('users', 'restaurant_orders.user_id', '=', 'users.id')
            ->whereBetween('restaurant_orders.created_at', [$startDate, $endDate])
            ->selectRaw('users.name as user_name, COUNT(restaurant_orders.id) as order_count')
            ->groupBy('user_name')
            ->orderByDesc('order_count')
            ->limit(10)
            ->get();

        return response()->json($topUsers);
    }

    public function salesSummary(Request $request)
    {
        $days = in_array((int)$request->days, [1, 7, 15, 30, 60, 90, 365]) ? (int)$request->days : 7;

        $startDate = \Carbon\Carbon::now()->subDays($days)->startOfDay();
        $endDate = \Carbon\Carbon::now()->endOfDay();

        $summary = DB::table('restaurant_orders')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('
            COUNT(*) as total_orders,
            SUM(subtotal) as total_subtotal,
            SUM(discount) as total_discount,
            SUM(delivery_fee) as total_delivery_fee,
            SUM(total) as total_sales,
            SUM(subtotal - discount) as net_revenue
        ')
            ->first();

        return response()->json($summary);
    }

    public function orderStatusBreakdown()
    {
        $data = DB::table('restaurant_orders')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        return response()->json($data);
    }

    public function ordersByCity()
    {
        $data = DB::table('restaurant_orders')
            ->join('delivery_address', 'restaurant_orders.delivery_address_id', '=', 'delivery_address.id')
            ->select('delivery_address.city', DB::raw('COUNT(*) as total'))
            ->groupBy('delivery_address.city')
            ->pluck('total', 'delivery_address.city');

        return response()->json($data);
    }
}