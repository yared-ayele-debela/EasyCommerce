<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Delivery Addresses",
 *     description="API Endpoints for managing delivery addresses"
 * )
 */
class DeliveryAddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/delivery-addresses",
     *     summary="Get all delivery addresses of the authenticated user",
     *     tags={"Delivery Addresses"},
     *     operationId="getDeliveryAddresses",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function index()
    {
        return response()->json(DeliveryAddress::where('user_id', Auth::id())->get());
    }

    /**
     * @OA\Post(
     *     path="/api/delivery-addresses",
     *     summary="Create a new delivery address",
     *     tags={"Delivery Addresses"},
     *     operationId="createDeliveryAddress",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"address", "latitude", "longitude"},
     *             @OA\Property(property="address", type="string", example="123 Main St, City"),
     *             @OA\Property(property="latitude", type="number", format="float", example=9.027234),
     *             @OA\Property(property="longitude", type="number", format="float", example=38.746891)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Delivery address created successfully"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $address = DeliveryAddress::create([
            'user_id' => Auth::id(),
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json($address, 201);
    }
}
