<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Food;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'order_requests' => Order::where('status', 'pending')->count(),
            'running_orders' => Order::where('status', 'processing')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
            'reviews' => Review::count(),
            'popular_items' => Food::withCount('orders')->orderBy('orders_count', 'desc')->take(5)->get(),
        ]);
    }
}
