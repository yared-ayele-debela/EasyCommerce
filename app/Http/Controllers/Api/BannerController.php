<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    /**
     * Fetch active Ecommerce banners
     *
     * @OA\Get(
     *     path="/api/banners/ecommerce",
     *     summary="Get active Ecommerce banners",
     *     tags={"Banners"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
    public function getEcommerceBanners()
    {
        return response()->json(Banner::where('type', 'ecommerce')->where('status', 1)->get());
    }

    /**
     * Fetch active Restaurant banners
     *
     * @OA\Get(
     *     path="/api/banners/restaurant",
     *     summary="Get active Restaurant banners",
     *     tags={"Banners"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
    public function getRestaurantBanners()
    {
        return response()->json(Banner::where('type', 'restaurant')->where('status', 1)->get());
    }

    /**
     * Fetch active Hotel banners
     *
     * @OA\Get(
     *     path="/api/banners/hotel",
     *     summary="Get active Hotel banners",
     *     tags={"Banners"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
    public function getHotelBanners()
    {
        return response()->json(Banner::where('type', 'hotel')->where('status', 1)->get());
    }

    /**
     * Store a new banner
     *
     * @OA\Post(
     *     path="/api/banners",
     *     summary="Create a new banner",
     *     tags={"Banners"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"service_id", "product_id", "type", "title", "alt", "status"},
     *             @OA\Property(property="service_id", type="integer", example=1),
     *             @OA\Property(property="product_id", type="integer", example=101),
     *             @OA\Property(property="type", type="string", enum={"ecommerce", "restaurant", "hotel"}, example="ecommerce"),
     *             @OA\Property(property="image", type="string", example="https://example.com/banner.jpg"),
     *             @OA\Property(property="title", type="string", example="Best Selling Product"),
     *             @OA\Property(property="alt", type="string", example="Top Electronics"),
     *             @OA\Property(property="status", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Banner created successfully"),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'product_id' => 'required|integer',
            'type' => 'required|in:ecommerce,restaurant,hotel',
            'image' => 'nullable|string',
            'title' => 'required|string',
            'alt' => 'required|string',
            'status' => 'required|boolean'
        ]);

        $banner = Banner::create($request->all());
        return response()->json($banner, 201);
    }
}
