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
     *     path="/addresses",
     *     summary="Add a new address",
     *     tags={"Addresses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"street", "city", "state", "zip_code", "country", "lat", "lng", "address_name", "contact_name", "post_code", "phone", "label"},
     *             @OA\Property(property="street", type="string", example="123 Main St"),
     *             @OA\Property(property="city", type="string", example="Los Angeles"),
     *             @OA\Property(property="state", type="string", example="CA"),
     *             @OA\Property(property="zip_code", type="string", example="90001"),
     *             @OA\Property(property="country", type="string", example="USA"),
     *             @OA\Property(property="lat", type="number", format="float", example=34.0522),
     *             @OA\Property(property="lng", type="number", format="float", example=-118.2437),
     *             @OA\Property(property="address_name", type="string", example="My Home"),
     *             @OA\Property(property="contact_name", type="string", example="John Doe"),
     *             @OA\Property(property="post_code", type="string", example="90001"),
     *             @OA\Property(property="phone", type="string", example="+1234567890"),
     *             @OA\Property(property="label", type="string", enum={"home", "work", "other"}, example="home")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Address added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Address added successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to add address",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to add address"),
     *             @OA\Property(property="error", type="string")
     *         )
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
                'lat' => 'required|numeric',
                'lng' => 'required|numeric',
                'address_name' => 'required|string|max:255',
                'contact_name' => 'required|string|max:255',
                'post_code' => 'required|string|max:20',
                'phone' => 'required|string|max:20',
                'label' => 'required|in:home,work,other',
            ]);

            $address = Address::create($validatedData);

            return response()->json([
                'success' => true, 
                'message' => 'Address added successfully', 
                'data' => $address
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Failed to add address', 
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/addresses/{id}",
     *     summary="Update an address",
     *     tags={"Addresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="street", type="string", example="123 Main St"),
     *             @OA\Property(property="city", type="string", example="Los Angeles"),
     *             @OA\Property(property="state", type="string", example="CA"),
     *             @OA\Property(property="zip_code", type="string", example="90001"),
     *             @OA\Property(property="country", type="string", example="USA"),
     *             @OA\Property(property="lat", type="number", format="float", example=34.0522),
     *             @OA\Property(property="lng", type="number", format="float", example=-118.2437),
     *             @OA\Property(property="address_name", type="string", example="My Home"),
     *             @OA\Property(property="contact_name", type="string", example="John Doe"),
     *             @OA\Property(property="post_code", type="string", example="90001"),
     *             @OA\Property(property="phone", type="string", example="+1234567890"),
     *             @OA\Property(property="label", type="string", enum={"home", "work", "other"}, example="home")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Address updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Address updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Address not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Address not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update address",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to update address"),
     *             @OA\Property(property="error", type="string")
     *         )
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
                'lat' => 'sometimes|numeric',
                'lng' => 'sometimes|numeric',
                'address_name' => 'sometimes|string|max:255',
                'contact_name' => 'sometimes|string|max:255',
                'post_code' => 'sometimes|string|max:20',
                'phone' => 'sometimes|string|max:20',
                'label' => 'sometimes|in:home,work,other',
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