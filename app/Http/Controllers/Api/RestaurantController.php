<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/restaurants/nearby",
     *     summary="Get Nearby Restaurants by Latitude and Longitude",
     *     description="Retrieve a list of all nearby restaurants based on the user's latitude and longitude.",
     *     operationId="getNearbyRestaurantsByLatLong",
     *     tags={"Restaurants"},
     *     @OA\Parameter(
     *         name="latitude",
     *         in="query",
     *         description="The latitude of the user's location",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
     *             format="float"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="longitude",
     *         in="query",
     *         description="The longitude of the user's location",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
     *             format="float"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="radius",
     *         in="query",
     *         description="The radius (in kilometers) to search for nearby restaurants",
     *         required=false,
     *         @OA\Schema(
     *             type="number",
     *             format="float",
     *             default=2
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="latitude", type="number", format="float"),
     *                 @OA\Property(property="longitude", type="number", format="float"),
     *                 @OA\Property(property="distance", type="number", format="float")
     *             )
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
        $latitude = request()->query('latitude');
        $longitude = request()->query('longitude');
        $radius = request()->query('radius', 2); // Default radius is 10 km

        if (!$latitude || !$longitude) {
            return response()->json(['error' => 'Latitude and Longitude parameters are required'], 400);
        }

        $restaurants = Restaurant::selectRaw(
            "*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
            [$latitude, $longitude, $latitude]
        )
        ->having('distance', '<=', $radius)
        ->orderBy('distance')
        ->get();

        return response()->json($restaurants);
    }
    // public function nearbyRestaurants()
    // {
    //     return response()->json(Restaurant::all());
    // }
}
