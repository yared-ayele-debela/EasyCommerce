<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Exception;

/**
 * @OA\Info(
 *      title="EasyCommerce API",
 *      version="1.0.0",
 *      description="API documentation for EasyCommerce",
 *      @OA\Contact(
 *          email="support@example.com"
 *      )
 * )
 */
class AddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/addresses",
     *     summary="Fetch all addresses",
     *     tags={"Addresses"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all addresses",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to fetch addresses"
     *     )
     * )
     */
    public function index()
    {
        try {
            $addresses = Address::all();
            return response()->json(['success' => true, 'data' => $addresses], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch addresses', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/addresses",
     *     summary="Add a new address",
     *     tags={"Addresses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="street", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="state", type="string"),
     *             @OA\Property(property="zip_code", type="string"),
     *             @OA\Property(property="country", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Address added successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to add address"
     *     )
     * )
     */
    public function add(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'street' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:20',
                'country' => 'required|string|max:255',
            ]);

            $address = Address::create($validatedData);

            return response()->json(['success' => true, 'message' => 'Address added successfully', 'data' => $address], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to add address', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/addresses/{id}",
     *     summary="Update an existing address",
     *     tags={"Addresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the address to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="street", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="state", type="string"),
     *             @OA\Property(property="zip_code", type="string"),
     *             @OA\Property(property="country", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Address updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Address not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update address"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $address = Address::find($id);

            if (!$address) {
                return response()->json(['success' => false, 'message' => 'Address not found'], 404);
            }

            $validatedData = $request->validate([
                'street' => 'sometimes|string|max:255',
                'city' => 'sometimes|string|max:255',
                'state' => 'sometimes|string|max:255',
                'zip_code' => 'sometimes|string|max:20',
                'country' => 'sometimes|string|max:255',
            ]);

            $address->update($validatedData);

            return response()->json(['success' => true, 'message' => 'Address updated successfully', 'data' => $address], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update address', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/addresses/{id}",
     *     summary="Delete an address",
     *     tags={"Addresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the address to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Address deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Address not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to delete address"
     *     )
     * )
     */
    public function delete($id)
    {
        try {
            $address = Address::find($id);

            if (!$address) {
                return response()->json(['success' => false, 'message' => 'Address not found'], 404);
            }

            $address->delete();

            return response()->json(['success' => true, 'message' => 'Address deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete address', 'error' => $e->getMessage()], 500);
        }
    }
}