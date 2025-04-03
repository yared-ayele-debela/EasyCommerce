<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\FoodCategory;

class RestaurantController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/restaurants",
     *     summary="Get all restaurants",
     *     description="Retrieve a list of all restaurants with their associated country, food categories, and foods.",
     *     operationId="getAllRestaurants",
     *     tags={"Restaurants"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with a list of restaurants",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="Restaurant ID"),
     *                 @OA\Property(property="name", type="string", description="Restaurant name"),
     *                 @OA\Property(property="country", type="object", description="Associated country"),
     *                 @OA\Property(
     *                     property="food_categories",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", description="Food category ID"),
     *                         @OA\Property(property="name", type="string", description="Food category name"),
     *                         @OA\Property(
     *                             property="foods",
     *                             type="array",
     *                             @OA\Items(
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", description="Food ID"),
     *                                 @OA\Property(property="name", type="string", description="Food name"),
     *                                 @OA\Property(property="price", type="number", format="float", description="Food price")
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(
            Restaurant::with(['country', 'foodCategories.foods'])->get()
        );
    }

    /**
     * @OA\Get(
     *     path="/api/restaurants/{id}",
     *     summary="Get a specific restaurant",
     *     description="Retrieve a specific restaurant by its ID, including its associated country, food categories, and foods.",
     *     operationId="getRestaurantById",
     *     tags={"Restaurants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the restaurant to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with the restaurant details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="Restaurant ID"),
     *             @OA\Property(property="name", type="string", description="Restaurant name"),
     *             @OA\Property(property="country", type="object", description="Associated country"),
     *             @OA\Property(
     *                 property="food_categories",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="Food category ID"),
     *                     @OA\Property(property="name", type="string", description="Food category name"),
     *                     @OA\Property(
     *                         property="foods",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", description="Food ID"),
     *                             @OA\Property(property="name", type="string", description="Food name"),
     *                             @OA\Property(property="price", type="number", format="float", description="Food price")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant not found"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(
            Restaurant::with(['country', 'foodCategories.foods'])->findOrFail($id)
        );
    }
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
        $radius = request()->query('radius', 2); // Default radius is 2 km

        if (!$latitude || !$longitude) {
            return response()->json(['error' => 'Latitude and Longitude parameters are required'], 400);
        }

        $restaurants = Restaurant::selectRaw(
            "*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
            [$latitude, $longitude, $latitude]
        )
        ->having('distance', '<=', $radius)
        ->orderBy('distance')
        ->get()
        ->map(function ($restaurant) use ($latitude, $longitude) {
            $restaurant->distance_in_meters = $restaurant->distance * 1000; // Convert distance to meters
            return $restaurant;
        });

        return response()->json($restaurants);
    }

    /**
     * @OA\Get(
     *     path="/api/restaurants/country/{countryId}",
     *     summary="Get restaurants by country",
     *     description="Retrieve a list of restaurants filtered by the specified country ID, including their food categories and foods.",
     *     operationId="getRestaurantsByCountry",
     *     tags={"Restaurants"},
     *     @OA\Parameter(
     *         name="countryId",
     *         in="path",
     *         description="ID of the country to filter restaurants by",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with a list of restaurants",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="Restaurant ID"),
     *                 @OA\Property(property="name", type="string", description="Restaurant name"),
     *                 @OA\Property(property="country_id", type="integer", description="Country ID"),
     *                 @OA\Property(
     *                     property="food_categories",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", description="Food category ID"),
     *                         @OA\Property(property="name", type="string", description="Food category name"),
     *                         @OA\Property(
     *                             property="foods",
     *                             type="array",
     *                             @OA\Items(
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", description="Food ID"),
     *                                 @OA\Property(property="name", type="string", description="Food name"),
     *                                 @OA\Property(property="price", type="number", format="float", description="Food price")
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Country not found"
     *     )
     * )
     */
    public function restaurantsByCountry($countryId)
    {
        $restaurants = Restaurant::with(['foodCategories.foods'])
            ->where('country_id', $countryId)
            ->get();

        return response()->json($restaurants);
    }
    // public function nearbyRestaurants()
    // {
    //     return response()->json(Restaurant::all());
    // }
    /**
     * @OA\Get(
     *     path="/api/restaurants/food-category/{parentCatId}",
     *     summary="Get restaurants by food category",
     *     description="Retrieve a list of restaurants that have food categories under the specified parent category ID, including the subcategories and their foods.",
     *     operationId="getRestaurantsByFoodCategory",
     *     tags={"Restaurants"},
     *     @OA\Parameter(
     *         name="parentCatId",
     *         in="path",
     *         description="ID of the parent food category",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with a list of restaurants and their food categories",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="Restaurant ID"),
     *                 @OA\Property(property="name", type="string", description="Restaurant name"),
     *                 @OA\Property(
     *                     property="food_categories",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", description="Food category ID"),
     *                         @OA\Property(property="category_name", type="string", description="Food category name"),
     *                         @OA\Property(
     *                             property="foods",
     *                             type="array",
     *                             @OA\Items(
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", description="Food ID"),
     *                                 @OA\Property(property="name", type="string", description="Food name"),
     *                                 @OA\Property(property="price", type="number", format="float", description="Food price")
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Parent category not found"
     *     )
     * )
     */
    public function restaurantsByFoodCategory($parentCatId)
    {
        // Get all subcategories under the given parent_cat_id
        $subCategoryIds = FoodCategory::where('parent_cat_id', $parentCatId)->pluck('id')->toArray();
        
        // Include parentCatId in the search
        $categoryIds = array_merge([(int)$parentCatId], $subCategoryIds);

        // Fetch restaurants that have at least one food under these categories
        $restaurants = Restaurant::whereHas('foods', function ($query) use ($categoryIds) {
            // $query->whereIn('category_id', $categoryIds);
        })
        ->with([
            'foods' => function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds)
                    ->select('id', 'name', 'description', 'price', 'image', 'restaurant_id', 'category_id');
            }
        ])
        ->get();

        if ($restaurants->isEmpty()) {
            return response()->json(['error' => 'No restaurants found for the given parent category ID'], 404);
        }

        return response()->json($restaurants);
    }


}
