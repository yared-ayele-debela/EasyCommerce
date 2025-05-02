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
     *     path="/api/restaurants/{id}/gallery",
     *     summary="Get restaurant gallery images",
     *     description="Retrieve a list of gallery images for a specific restaurant by its ID.",
     *     operationId="getRestaurantGallery",
     *     tags={"Restaurants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the restaurant to retrieve gallery images for",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with a list of gallery images",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="Image ID"),
     *                 @OA\Property(property="image_path", type="string", description="Image path")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant not found"
     *     )
     * )
     */
    public function getGallery($id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json(['error' => 'Restaurant not found'], 404);
        }

        $gallery = $restaurant->images()->get(['id', 'image_path']);

        return response()->json($gallery);
    }

    /**
     * @OA\Get(
     *     path="/api/restaurants/{id}/food-category",
     *     summary="Get food categories and first category foods by restaurant ID",
     *     description="Retrieve a list of food categories for a specific restaurant and the foods under the first category.",
     *     operationId="getFoodCategoryAndFirstCategoryFoods",
     *     tags={"Restaurants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the restaurant to retrieve food categories and foods for",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with food categories and first category foods",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="food_categories",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="Food category ID"),
     *                     @OA\Property(property="name", type="string", description="Food category name")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="first_category_foods",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="Food ID"),
     *                     @OA\Property(property="name", type="string", description="Food name"),
     *                     @OA\Property(property="price", type="number", format="float", description="Food price")
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
    public function getFoodCategoryAndFirstCategoryFoods($id)
    {
        $restaurant = Restaurant::with('foodCategories.foods')->find($id);

        if (!$restaurant) {
            return response()->json(['error' => 'Restaurant not found'], 404);
        }

        $foodCategories = $restaurant->foodCategories;
        $firstCategoryFoods = $foodCategories->isNotEmpty() ? $foodCategories->first()->foods : [];

        return response()->json([
            'food_categories' => $foodCategories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            }),
            'first_category_foods' => $firstCategoryFoods->map(function ($food) {
                return [
                    'id' => $food->id,
                    'name' => $food->name,
                    'price' => $food->price,
                ];
            }),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/favorites",
     *     summary="Add an item to favorites",
     *     description="Add a restaurant, food, hotel, or e-commerce product to the user's favorites.",
     *     operationId="addToFavorites",
     *     tags={"Favorites"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="favoritable_id", type="integer", description="ID of the item to add to favorites"),
     *             @OA\Property(property="favoritable_type", type="string", description="Type of the item (e.g., 'restaurant', 'food', 'hotel', 'product')")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully added to favorites",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", description="Success message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function addToFavorites()
    {
        $data = request()->validate([
            'favoritable_id' => 'required|integer',
            'favoritable_type' => 'required|string|in:restaurant,food,hotel,product',
        ]);

        $userId = auth()->id(); // Assuming user authentication is implemented

        \DB::table('favorites')->updateOrInsert(
            [
                'user_id' => $userId,
                'favoritable_id' => $data['favoritable_id'],
                'favoritable_type' => $data['favoritable_type'],
            ],
            ['created_at' => now(), 'updated_at' => now()]
        );

        return response()->json(['message' => 'Added to favorites successfully']);
    }

    /**
     * @OA\Get(
     *     path="/api/favorites",
     *     summary="Get user's favorites",
     *     description="Retrieve the list of the user's favorite items (restaurants, foods, hotels, and products).",
     *     operationId="getFavorites",
     *     tags={"Favorites"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with a list of favorites",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="restaurants",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="Restaurant ID"),
     *                     @OA\Property(property="name", type="string", description="Restaurant name")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="foods",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="Food ID"),
     *                     @OA\Property(property="name", type="string", description="Food name"),
     *                     @OA\Property(property="price", type="number", format="float", description="Food price")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="hotels",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="Hotel ID"),
     *                     @OA\Property(property="name", type="string", description="Hotel name")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="Product ID"),
     *                     @OA\Property(property="name", type="string", description="Product name"),
     *                     @OA\Property(property="price", type="number", format="float", description="Product price")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getFavorites()
    {
        $userId = auth()->id(); // Assuming user authentication is implemented

        $favorites = \DB::table('favorites')->where('user_id', $userId)->get();

        $restaurantIds = $favorites->where('favoritable_type', 'restaurant')->pluck('favoritable_id');
        $foodIds = $favorites->where('favoritable_type', 'food')->pluck('favoritable_id');
        $hotelIds = $favorites->where('favoritable_type', 'hotel')->pluck('favoritable_id');
        $productIds = $favorites->where('favoritable_type', 'product')->pluck('favoritable_id');

        $restaurants = Restaurant::whereIn('id', $restaurantIds)->get(['id', 'name']);
        $foods = \App\Models\Food::whereIn('id', $foodIds)->get(['id', 'name', 'price']);
        $hotels = \App\Models\Hotel::whereIn('id', $hotelIds)->get(['id', 'name']);
        $products = \App\Models\Product::whereIn('id', $productIds)->get(['id', 'name', 'price']);

        return response()->json([
            'restaurants' => $restaurants,
            'foods' => $foods,
            'hotels' => $hotels,
            'products' => $products,
        ]);
    }
    /**
     * @OA\Delete(
     *     path="/api/favorites",
     *     summary="Remove an item from favorites",
     *     description="Remove a restaurant, food, hotel, or e-commerce product from the user's favorites.",
     *     operationId="removeFromFavorites",
     *     tags={"Favorites"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="favoritable_id", type="integer", description="ID of the item to remove from favorites"),
     *             @OA\Property(property="favoritable_type", type="string", description="Type of the item (e.g., 'restaurant', 'food', 'hotel', 'product')")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully removed from favorites",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", description="Success message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function remove()
    {
        $data = request()->validate([
            'favoritable_id' => 'required|integer',
            'favoritable_type' => 'required|string|in:restaurant,food,hotel,product',
        ]);

        $userId = auth()->id(); // Assuming user authentication is implemented

        $deleted = \DB::table('favorites')
            ->where('user_id', $userId)
            ->where('favoritable_id', $data['favoritable_id'])
            ->where('favoritable_type', $data['favoritable_type'])
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Removed from favorites successfully']);
        }

        return response()->json(['error' => 'Item not found in favorites'], 400);
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
