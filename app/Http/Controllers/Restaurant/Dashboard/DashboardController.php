<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Coupon;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\OrderItem;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantMenu;
use App\Models\Restaurant\SliderBanner;
use App\Models\Restaurant\Subcategory;
use App\Models\Roles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $admin = Auth::guard('admin')->user();

        $role=Roles::where('name',$admin->type)->first();

        $group = $role->group ?? null;

        if ($group === "general") {

            // 🧠 Super Admin: Show global counts
            $total_coupon = Coupon::count();
            $total_product = Product::count();
            $total_restaurant = Restaurant::count();
            $total_order = Order::count();

            $total_pending_order = Order::where('status', 'pending')->count();
            $total_processing_order = Order::where('status', 'processing')->count();
            $total_completed_order = Order::where('status', 'completed')->count();
            $total_canceled_order = Order::where('status', 'canceled')->count();
        } else {
            // 👤 Vendor Admin: Filter by admin_id
            $restaurantIds = Restaurant::where('admin_id', $admin->id)->pluck('id');

            $productIds = Product::whereIn('restaurant_id', $restaurantIds)->pluck('id');

            $orderIds = OrderItem::whereIn('product_id', $productIds)->pluck('order_id')->unique();

            $total_coupon = Coupon::where('admin_id', $admin->id)->count();
            $total_restaurant = $restaurantIds->count();
            $total_product = Product::whereIn('restaurant_id', $restaurantIds)->count();
            $total_order = Order::whereIn('id', $orderIds)->count();

            $total_pending_order = Order::whereIn('id', $orderIds)->where('status', 'pending')->count();
            $total_processing_order = Order::whereIn('id', $orderIds)->where('status', 'processing')->count();
            $total_completed_order = Order::whereIn('id', $orderIds)->where('status', 'completed')->count();
            $total_canceled_order = Order::whereIn('id', $orderIds)->where('status', 'canceled')->count();
        }

        return view('Restaurant.dashboard.index', compact('total_restaurant', 'total_product', 'total_coupon', 'total_menu', 'total_subcategory', 'total_category', 'total_slider', 'total_order', 'total_canceled_order', 'total_pending_order', 'total_completed_order', 'total_processing_order'));
    }

    public function orderTrend(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $days = in_array((int) $request->days, [7, 15, 30, 60, 90, 365]) ? (int) $request->days : 365;
        $startDate = now()->subDays($days)->startOfDay();

        $query = DB::table('restaurant_orders')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as order_count, SUM(total) as total_sales')
            ->where('created_at', '>=', $startDate)
            ->where('status', 'completed');

        if ($admin->type !== 'Super Admin') {
            $restaurantIds = DB::table('restaurants')->where('admin_id', $admin->id)->pluck('id');
            $productIds = DB::table('restaurant_products')->whereIn('restaurant_id', $restaurantIds)->pluck('id');
            $orderIds = DB::table('restaurant_order_items')->whereIn('product_id', $productIds)->pluck('order_id')->unique();
            $query->whereIn('id', $orderIds);
        }

        $orders = $query->groupBy('date')->orderBy('date')->get();
        return response()->json($orders);
    }

    public function ordersByCategory(Request $request)
    {
        /* -----------------------------------------------------------------
     | 1.  Validate the period (days)
     * -----------------------------------------------------------------*/
        $days = in_array((int) $request->days, [7, 15, 30, 60, 90, 365])
            ? (int) $request->days
            : 7;

        $startDate = Carbon::now()->subDays($days)->startOfDay();
        $endDate   = Carbon::now()->endOfDay();

        /* -----------------------------------------------------------------
     | 2.  Determine admin scope
     * -----------------------------------------------------------------*/
        $admin   = Auth::guard('admin')->user();
        $isSuper = strcasecmp($admin->type, 'Super Admin') === 0;

        // For non-super admins: build a list of allowed product IDs
        $allowedProductIds = null;

        if (!$isSuper) {
            $restaurantIds = DB::table('restaurants')
                ->where('admin_id', $admin->id)
                ->pluck('id');

            $allowedProductIds = DB::table('restaurant_products')
                ->whereIn('restaurant_id', $restaurantIds)
                ->pluck('id');
        }

        /* -----------------------------------------------------------------
     | 3.  Build the query
     * -----------------------------------------------------------------*/
        $query = DB::table('restaurant_order_items')
            ->join('restaurant_products',      'restaurant_order_items.product_id', '=', 'restaurant_products.id')
            ->join('restaurant_subcategories', 'restaurant_products.subcategory_id', '=', 'restaurant_subcategories.id')
            ->join('restaurant_categories',    'restaurant_subcategories.category_id', '=', 'restaurant_categories.id')
            ->whereBetween('restaurant_order_items.created_at', [$startDate, $endDate])
            ->selectRaw('restaurant_categories.name AS category_name, COUNT(restaurant_order_items.id) AS order_count')
            ->groupBy('category_name')
            ->orderByDesc('order_count');

        // Apply admin scope when necessary
        if (!$isSuper) {
            $query->whereIn('restaurant_order_items.product_id', $allowedProductIds);
        }

        $orderData = $query->get();

        return response()->json($orderData);
    }

    public function topOrderingUsers(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $isSuperAdmin = strtolower($admin->type) === 'Super Admin';

        $days = in_array((int)$request->days, [7, 15, 30, 60, 90, 365]) ? (int)$request->days : 7;

        $startDate = Carbon::now()->subDays($days)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $query = DB::table('restaurant_orders as o')
            ->join('users as u', 'o.user_id', '=', 'u.id')
            ->whereBetween('o.created_at', [$startDate, $endDate]);

        if (!$isSuperAdmin) {
            $query->join('restaurant_order_items as oi', 'oi.order_id', '=', 'o.id')
                ->join('restaurant_products as p', 'oi.product_id', '=', 'p.id')
                ->join('restaurants as r', 'p.restaurant_id', '=', 'r.id')
                ->where('r.admin_id', $admin->id);
        }

        $topUsers = $query
            ->selectRaw('u.name as user_name, COUNT(DISTINCT o.id) as order_count')
            ->groupBy('u.name')
            ->orderByDesc('order_count')
            ->limit(10)
            ->get();

        return response()->json($topUsers);
    }

    public function salesSummary(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $isSuperAdmin = strtolower($admin->type) === 'Super Admin';

        $days = in_array((int)$request->days, [1, 7, 15, 30, 60, 90, 365]) ? (int)$request->days : 7;

        $startDate = Carbon::now()->subDays($days)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $query = DB::table('restaurant_orders as o')
            ->whereBetween('o.created_at', [$startDate, $endDate]);

        if (!$isSuperAdmin) {
            $query->join('restaurant_order_items as oi', 'oi.order_id', '=', 'o.id')
                ->join('restaurant_products as p', 'oi.product_id', '=', 'p.id')
                ->join('restaurants as r', 'p.restaurant_id', '=', 'r.id')
                ->where('r.admin_id', $admin->id);
        }

        $summary = $query->selectRaw('
        COUNT(DISTINCT o.id) as total_orders,
        SUM(o.subtotal) as total_subtotal,
        SUM(o.discount) as total_discount,
        SUM(o.delivery_fee) as total_delivery_fee,
        SUM(o.total) as total_sales,
        SUM(o.tip_amount) as total_tip,
        SUM(o.tax) as total_tax,
        SUM(o.total - o.tax) as total_profit
    ')->first();

        return response()->json($summary);
    }

    public function orderStatusBreakdown()
    {
        $admin = Auth::guard('admin')->user();
        $isSuperAdmin = strtolower($admin->type) === 'Super Admin';

        $query = DB::table('restaurant_orders as o')
            ->select('o.status', DB::raw('COUNT(DISTINCT o.id) as count'))
            ->groupBy('o.status');

        if (!$isSuperAdmin) {
            // Join order_items → products → restaurants to filter by current admin
            $query->join('restaurant_order_items as oi', 'oi.order_id', '=', 'o.id')
                ->join('restaurant_products as p', 'oi.product_id', '=', 'p.id')
                ->join('restaurants as r', 'p.restaurant_id', '=', 'r.id')
                ->where('r.admin_id', $admin->id);
        }

        $data = $query->pluck('count', 'status');

        return response()->json($data);
    }


    public function ordersByCity()
    {
        $admin = Auth::guard('admin')->user();
        $isSuperAdmin = strtolower($admin->type) === 'Super Admin';

        $query = DB::table('restaurant_orders as o')
            ->join('delivery_address as da', 'o.delivery_address_id', '=', 'da.id')
            ->select('da.city', DB::raw('COUNT(DISTINCT o.id) as total'))
            ->groupBy('da.city');

        if (!$isSuperAdmin) {
            $query->join('restaurant_order_items as oi', 'oi.order_id', '=', 'o.id')
                ->join('restaurant_products as p', 'oi.product_id', '=', 'p.id')
                ->join('restaurants as r', 'p.restaurant_id', '=', 'r.id')
                ->where('r.admin_id', $admin->id);
        }

        $data = $query->pluck('total', 'city');

        return response()->json($data);
    }
}
