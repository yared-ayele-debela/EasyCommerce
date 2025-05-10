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
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
        }

        $addresses = DeliveryAddress::where('user_id', Auth::id())->get();

        return response()->json([
            'success' => true,
            'message' => 'Delivery addresses retrieved successfully.',
            'data' => $addresses,
        ], 200);
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
     *             required={"name", "address", "city", "state", "country", "postcode", "mobile", "latitude", "longitude"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="address", type="string", example="123 Main St, City"),
     *             @OA\Property(property="city", type="string", example="New York"),
     *             @OA\Property(property="state", type="string", example="NY"),
     *             @OA\Property(property="country", type="string", example="USA"),
     *             @OA\Property(property="label", type="string", example="Home"),
     *             @OA\Property(property="postcode", type="string", example="10001"),
     *             @OA\Property(property="mobile", type="string", example="+1234567890"),
     *             @OA\Property(property="latitude", type="number", format="float", example=40.712776),
     *             @OA\Property(property="longitude", type="number", format="float", example=-74.005974)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Delivery address created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Delivery address created successfully."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="address", type="string", example="123 Main St, City"),
     *                 @OA\Property(property="city", type="string", example="New York"),
     *                 @OA\Property(property="state", type="string", example="NY"),
     *                 @OA\Property(property="country", type="string", example="USA"),
     *                 @OA\Property(property="label", type="string", example="Home"),
     *                 @OA\Property(property="postcode", type="string", example="10001"),
     *                 @OA\Property(property="mobile", type="string", example="+1234567890"),
     *                 @OA\Property(property="latitude", type="number", format="float", example=40.712776),
     *                 @OA\Property(property="longitude", type="number", format="float", example=-74.005974),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="status", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=500, description="Failed to create delivery address")
     * )
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'label' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {
            $validatedData['user_id'] = Auth::id();
            $validatedData['label'] = $validatedData['label'] ?? 'Home';
            $validatedData['status'] = 1;

            $address = DeliveryAddress::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Delivery address created successfully.',
                'data' => $address,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create delivery address.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/delivery-addresses/{id}",
     *     summary="Delete a delivery address",
     *     tags={"Delivery Addresses"},
     *     operationId="deleteDeliveryAddress",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the delivery address to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Delivery address deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Delivery address deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Delivery address not found"),
     *     @OA\Response(response=500, description="Failed to delete delivery address")
     * )
     */
    public function destroy($id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
        }
        $address = DeliveryAddress::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Delivery address not found.',
            ], 404);
        }

        try {
            $address->delete();

            return response()->json([
                'success' => true,
                'message' => 'Delivery address deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete delivery address.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
