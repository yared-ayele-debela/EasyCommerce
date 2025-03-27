<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    /**
     * Fetch all active banners.
     *
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *     path="/api/banners/active",
     *     summary="Fetch all active banners",
     *     description="Retrieve a list of all active banners.",
     *     operationId="fetchActiveBanners",
     *     tags={"Banners"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function fetchActiveBanners(): JsonResponse
    {
        $activeBanners = Banner::where('status', 1)->get();

        return response()->json([
            'success' => true,
            'data' => $activeBanners,
        ]);
    }
}