<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/restaurants/nearby",
     *     summary="Get Nearby Restaurants by City",
     *     description="Retrieve a list of all nearby restaurants based on the user's city.",
     *     operationId="getNearbyRestaurantsByCity",
     *     tags={"Restaurants"},
     *     @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="The city to filter nearby restaurants",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function nearbyRestaurants()
    {
        $city = request()->query('city');

        if (!$city) {
            return response()->json(['error' => 'City parameter is required'], 400);
        }

        $restaurants = Restaurant::where('city', $city)->get();

        return response()->json($restaurants);
    }
    // public function nearbyRestaurants()
    // {
    //     return response()->json(Restaurant::all());
    // }
}
