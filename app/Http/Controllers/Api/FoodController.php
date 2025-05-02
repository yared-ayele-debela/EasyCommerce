<?php

namespace App\Http\Controllers\Api;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/foods",
     *     summary="Get all foods",
     *     tags={"Foods"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all foods with their categories"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Food::with('category')->get());
    }

    

    /**
     * @OA\Get(
     *     path="/api/foods/{id}",
     *     summary="Get a specific food by ID",
     *     tags={"Foods"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the food",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of the food with its category"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Food not found"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(Food::with('category')->findOrFail($id));
    }

    

    /**
     * @OA\Post(
     *     path="/api/foods",
     *     summary="Create a new food",
     *     tags={"Foods"},
     *     @OA\RequestBody(
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Food created successfully"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'category_id' => 'nullable|exists:food_categories,id',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'is_special_offer' => 'nullable|boolean',
            'available' => 'nullable|boolean',
        ]);

        return response()->json(Food::create($data), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/foods/special-offers",
     *     summary="Get foods with special offers",
     *     tags={"Foods"},
     *     @OA\Response(
     *         response=200,
     *         description="List of foods with special offers"
     *     )
     * )
     */
    public function specialOffers()
    {
        $specialOffers = Food::where('is_special_offer', true)->with('category')->get();

        return response()->json($specialOffers);
    }

    /**
     * @OA\Put(
     *     path="/api/foods/{id}",
     *     summary="Update an existing food",
     *     tags={"Foods"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the food",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Food updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Food not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $food = Food::findOrFail($id);
        $food->update($request->all());

        return response()->json($food);
    }

    

    /**
     * @OA\Delete(
     *     path="/api/foods/{id}",
     *     summary="Delete a food",
     *     tags={"Foods"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the food",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Food deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Food not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        Food::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }

    /**
     * @OA\Get(
     *     path="/api/foods/category/{categoryId}",
     *     summary="Get foods by category",
     *     tags={"Foods"},
     *     @OA\Parameter(
     *         name="categoryId",
     *         in="path",
     *         required=true,
     *         description="ID of the category",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of foods in the specified category"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function getByCategory($categoryId)
    {
        $foods = Food::where('category_id', $categoryId)->with('category')->get();

        if ($foods->isEmpty()) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($foods);
    }

    /**
     * @OA\Get(
     *     path="/api/foods/parent-category/{parentCatId}",
     *     summary="Get foods by parent category",
     *     tags={"Foods"},
     *     @OA\Parameter(
     *         name="parentCatId",
     *         in="path",
     *         required=true,
     *         description="ID of the parent category",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of foods under subcategories of the specified parent category"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Parent category not found or no foods available"
     *     )
     * )
     */
    public function getByParentCategory($parentCatId)
    {
        $subCategoryIds = \DB::table('food_categories')
            ->where('parent_cat_id', $parentCatId)
            ->pluck('id');

        if ($subCategoryIds->isEmpty()) {
            return response()->json(['message' => 'Parent category not found or no subcategories available'], 404);
        }

        $foods = Food::whereIn('category_id', $subCategoryIds)->with('category')->get();

        if ($foods->isEmpty()) {
            return response()->json(['message' => 'No foods available under the specified parent category'], 404);
        }

        return response()->json($foods);
    }

    /**
     * @OA\Get(
     *     path="/api/foods/search",
     *     summary="Search foods by name or description",
     *     tags={"Foods"},
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         description="Search query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of foods matching the search query"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No foods found"
     *     )
     * )
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $foods = Food::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->with('category')
            ->get();

        if ($foods->isEmpty()) {
            return response()->json(['message' => 'No foods found'], 404);
        }

        return response()->json($foods);
    }

    /**
     * @OA\Get(
     *     path="/api/foods/filter",
     *     summary="Filter foods by price range, availability, and delivery time",
     *     tags={"Foods"},
     *     @OA\Parameter(
     *         name="min_price",
     *         in="query",
     *         required=false,
     *         description="Minimum price",
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *         name="max_price",
     *         in="query",
     *         required=false,
     *         description="Maximum price",
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *         name="delivery_time",
     *         in="query",
     *         required=false,
     *         description="Maximum delivery time in minutes",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of foods matching the filter criteria"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No foods found"
     *     )
     * )
     */
    public function filter(Request $request)
    {
        $query = Food::query();

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        if ($request->has('delivery_time')) {
            $deliveryTime = $request->input('delivery_time');
            
            // Convert delivery time to minutes if it's in '1h 30m' or '0:30' format
            if (preg_match('/(\d+)h\s*(\d+)?m?/', $deliveryTime, $matches)) {
            $hours = (int) $matches[1];
            $minutes = isset($matches[2]) ? (int) $matches[2] : 0;
            $deliveryTimeInMinutes = ($hours * 60) + $minutes;
            } elseif (preg_match('/(\d+):(\d+)/', $deliveryTime, $matches)) {
            $hours = (int) $matches[1];
            $minutes = (int) $matches[2];
            $deliveryTimeInMinutes = ($hours * 60) + $minutes;
            } else {
            $deliveryTimeInMinutes = (int) $deliveryTime; // Assume it's already in minutes
            }

            $query->where('delivery_time', '<=', $deliveryTimeInMinutes);
        }

        $foods = $query->with('category')->get();

        if ($foods->isEmpty()) {
            return response()->json(['message' => 'No foods found'], 404);
        }

        return response()->json($foods);
    }
}
