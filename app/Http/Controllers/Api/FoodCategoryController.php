<?php

namespace App\Http\Controllers\Api;

use App\Models\FoodCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="FoodCategory",
 *     description="API Endpoints for managing food categories"
 * )
 */
class FoodCategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/food-categories",
     *     tags={"FoodCategory"},
     *     summary="Get list of food categories",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(FoodCategory::with(['country', 'subCategories'])->get());
    }

    /**
     * @OA\Get(
     *     path="/api/main/food-categories",
     *     tags={"FoodCategory"},
     *     summary="Get list of food main categories",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function mainCategory()
    {
        return response()->json(FoodCategory::with(['country', 'subCategories'])->whereNull('parent_cat_id')->get());
    }

    

    /**
     * @OA\Get(
     *     path="/api/food-categories/{id}",
     *     tags={"FoodCategory"},
     *     summary="Get a specific food category",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the food category",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Food category not found"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(FoodCategory::with(['country', 'subCategories'])->findOrFail($id));
    }

    /**
     * @OA\Post(
     *     path="/api/food-categories",
     *     tags={"FoodCategory"},
     *     summary="Create a new food category",
     *     @OA\RequestBody(
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Food category created successfully"
     *     )
     * )
     */

    public function store(Request $request)
    {
        $data = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'parent_cat_id' => 'nullable|exists:food_categories,id',
            'category_name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        return response()->json(FoodCategory::create($data), 201);
    }

    /**
     * @OA\Put(
     *     path="/api/food-categories/{id}",
     *     tags={"FoodCategory"},
     *     summary="Update an existing food category",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the food category",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Food category updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Food category not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $category = FoodCategory::findOrFail($id);
        $category->update($request->all());

        return response()->json($category);
    }

    /**
     * @OA\Delete(
     *     path="/api/food-categories/{id}",
     *     tags={"FoodCategory"},
     *     summary="Delete a food category",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the food category",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Food category deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Food category not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        FoodCategory::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }

    /**
     * @OA\Get(
     *     path="/api/food-categories/with-parent/{parent_cat_id}",
     *     tags={"FoodCategory"},
     *     summary="Get food categories by parent category ID",
     *     @OA\Parameter(
     *         name="parent_cat_id",
     *         in="path",
     *         required=true,
     *         description="Parent category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No food categories found for the given parent category ID"
     *     )
     * )
     */
    public function getByParentCategory($parent_cat_id)
    {
        $categories = FoodCategory::where('parent_cat_id', $parent_cat_id)->get();

        if ($categories->isEmpty()) {
            return response()->json(['message' => 'No food categories found for the given parent category ID'], 404);
        }

        return response()->json($categories);
    }
}
