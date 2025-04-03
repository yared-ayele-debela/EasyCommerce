<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Countries;

class CountryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/countries",
     *     tags={"Countries"},
     *     summary="Get list of countries",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object"
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Countries::with('foodCategories')->get());
    }

    /**
     * @OA\Get(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     summary="Get a specific country by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the country to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Country not found"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(Countries::with(['foodCategories' => function ($query) {
            $query->whereNull('parent_cat_id');
        }])->findOrFail($id));
    }

    /**
     * @OA\Post(
     *     path="/api/countries",
     *     tags={"Countries"},
     *     summary="Create a new country",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "code"},
     *             @OA\Property(property="name", type="string", description="Name of the country"),
     *             @OA\Property(property="code", type="string", maxLength=5, description="Code of the country"),
     *             @OA\Property(property="image", type="string", nullable=true, description="Image URL of the country"),
     *             @OA\Property(property="food_image", type="string", nullable=true, description="Food image URL of the country")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Country created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|max:5',
            'image' => 'nullable|string',
            'food_image' => 'nullable|string',
        ]);

        return response()->json(Countries::create($data), 201);
    }

    /**
     * @OA\Put(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     summary="Update an existing country",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the country to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="Name of the country"),
     *             @OA\Property(property="code", type="string", maxLength=5, description="Code of the country"),
     *             @OA\Property(property="image", type="string", nullable=true, description="Image URL of the country"),
     *             @OA\Property(property="food_image", type="string", nullable=true, description="Food image URL of the country")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Country updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Country not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $Countries = Countries::findOrFail($id);
        $Countries->update($request->all());

        return response()->json($Countries);
    }

    /**
     * @OA\Delete(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     summary="Delete a country",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the country to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Country deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Country not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        Countries::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
