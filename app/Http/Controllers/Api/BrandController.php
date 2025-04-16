<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/brands",
     *     summary="Fetch all brands",
     *     tags={"Brands"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data"
     *             )
     *         )
     *     )
     * )
     *
     * Fetch all brands.
     *
     * @return JsonResponse
     */
    public function brand(): JsonResponse
    {
        $brands = Brand::all();
        return response()->json([
            'success' => true,
            'data' => $brands
        ]);
    }
}