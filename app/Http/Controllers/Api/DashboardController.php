<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Food;
use App\Models\Review;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Dashboard",
 *     description="API Endpoints for fetching dashboard statistics"
 * )
 */
class DashboardController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/dashboard",
     *     summary="Get dashboard statistics",
     *     tags={"Dashboard"},
     *     operationId="getDashboardStats",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Dashboard statistics retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="order_requests", type="integer", example=15),
     *             @OA\Property(property="running_orders", type="integer", example=8),
     *             @OA\Property(property="total_revenue", type="number", format="float", example=12500.50),
     *             @OA\Property(property="reviews", type="integer", example=200),
     *             @OA\Property(
     *                 property="popular_items",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Burger Deluxe"),
     *                     @OA\Property(property="orders_count", type="integer", example=100)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
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
