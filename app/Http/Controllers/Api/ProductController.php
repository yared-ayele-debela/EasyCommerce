<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints for managing products"
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products/deal-of-the-day",
     *     summary="Get deal of the day products",
     *     tags={"Products"},
     *     operationId="getDealOfTheDayProducts",
     *     @OA\Response(
     *         response=200,
     *         description="List of deal of the day products retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    // public function dealOfTheDay()
    // {
    //     try {
    //         $products = Product::where('deal_of_the_day', true)->get();
    //         return response()->json($products, 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Failed to fetch deal of the day products'], 500);
    //     }
    // }
    public function dealOfTheDay()
    {
        $today = Carbon::today()->toDateString();

        $deals = Product::whereNotNull('product_discount')
            ->where('product_discount', '>', 0)
            ->whereNotNull('discount_start_date')
            ->whereNotNull('discount_end_date')
            ->where('discount_start_date', '<=', $today)
            ->where('discount_end_date', '>=', $today)
            ->where('status', 1) // Ensure the product is active
            ->get();

        return response()->json($deals);
    }

    /**
     * @OA\Get(
     *     path="/api/products/trending",
     *     summary="Get trending products",
     *     tags={"Products"},
     *     operationId="getTrendingProducts",
     *     @OA\Response(
     *         response=200,
     *         description="List of trending products retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    // public function trending()
    // {
    //     try {
    //         $products = Product::where('trending', true)->get();
    //         return response()->json($products, 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Failed to fetch trending products'], 500);
    //     }
    // }
    public function trending()
    {
        // Get products that are featured or seasonal
        $trending = Product::where('is_featured', 'Yes')
                           ->orWhere('is_seasonal', 1)
                           ->where('status', 1) // Ensure product is active
                           ->orderBy('updated_at', 'desc') // You can adjust the order based on preferences
                           ->get();

        return response()->json($trending);
    }

    /**
     * @OA\Get(
     *     path="/api/products/latest",
     *     summary="Get latest products",
     *     tags={"Products"},
     *     operationId="getLatestProducts",
     *     @OA\Response(
     *         response=200,
     *         description="List of latest products retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function latest()
    {
        try {
            $products = Product::orderBy('created_at', 'desc')->take(10)->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch latest products'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/new-arrivals",
     *     summary="Get new arrival products",
     *     tags={"Products"},
     *     operationId="getNewArrivals",
     *     @OA\Response(
     *         response=200,
     *         description="List of new arrival products retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    // public function newArrivals()
    // {
    //     try {
    //         $products = Product::where('new_arrival', true)->get();
    //         return response()->json($products, 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Failed to fetch new arrivals'], 500);
    //     }
    // }
    public function newArrivals()
    {
        // Get products created in the last 30 days
        $newArrivals = Product::where('created_at', '>=', Carbon::now()->subDays(30))
                              ->where('status', 1) // Ensure product is active
                              ->orderBy('created_at', 'desc') // Order by most recently added
                              ->get();

        return response()->json($newArrivals);
    }

    /**
     * @OA\Get(
     *     path="/api/products/sponsored",
     *     summary="Get sponsored products",
     *     tags={"Products"},
     *     operationId="getSponsoredProducts",
     *     @OA\Response(
     *         response=200,
     *         description="List of sponsored products retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    // public function sponsored()
    // {
    //     try {
    //         $products = Product::where('sponsored', true)->get();
    //         return response()->json($products, 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Failed to fetch sponsored products'], 500);
    //     }
    // }
    public function sponsored()
    {
        // Get sponsored products
        $sponsored = Product::where('is_sponsored', 'Yes')
                            ->where('status', 1) // Ensure product is active
                            ->orderBy('updated_at', 'desc') // Order by most recently updated, you can change this
                            ->get();

        return response()->json($sponsored);
    }
    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Get product details",
     *     tags={"Products"},
     *     operationId="getProductDetail",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product details retrieved successfully"
     *     ),
     *     @OA\Response(response=404, description="Product not found"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function detail($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json($product, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch product details'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/search",
     *     summary="Search products by keyword",
     *     tags={"Products"},
     *     operationId="searchProducts",
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         required=true,
     *         description="Search keyword",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of products matching the search keyword retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function searchProduct(Request $request)
    {
        $keyword = $request->input('keyword');

        if (!$keyword) {
            return response()->json(['error' => 'Keyword is required'], 400);
        }

        $products = Product::where('product_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('description', 'LIKE', '%' . $keyword . '%')
            ->where('status', 1) // Ensure product is active
            ->get();

        return response()->json($products);
    }

    /**
     * @OA\Get(
     *     path="/api/products/category/{category_id}",
     *     summary="Get products by category",
     *     tags={"Products"},
     *     operationId="getProductsByCategory",
     *     @OA\Parameter(
     *         name="category_id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of products in the specified category retrieved successfully"
     *     ),
     *     @OA\Response(response=404, description="Category not found"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getProductsByCategory($category_id)
    {
        try {
            $products = Product::where('category_id', $category_id)
                               ->where('status', 1) // Ensure product is active
                               ->get();

            if ($products->isEmpty()) {
                return response()->json(['error' => 'No products found in this category'], 404);
            }

            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch products by category'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/parent-category/{parent_id}",
     *     summary="Get products by parent category",
     *     tags={"Products"},
     *     operationId="getProductsByParentCategory",
     *     @OA\Parameter(
     *         name="parent_id",
     *         in="path",
     *         required=true,
     *         description="Parent Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of products under the parent category retrieved successfully"
     *     ),
     *     @OA\Response(response=404, description="Parent category not found"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getProductsByParentCategory($parent_id)
    {
        try {
            // Fetch all child categories of the parent category
            $childCategoryIds = \App\Models\Category::where('parent_id', $parent_id)->pluck('id');

            // Include the parent category ID itself
            $categoryIds = $childCategoryIds->push($parent_id);

            // Fetch products belonging to the parent category and its child categories
            $products = Product::whereIn('category_id', $categoryIds)
                               ->where('status', 1) // Ensure product is active
                               ->get();

            if ($products->isEmpty()) {
                return response()->json(['error' => 'No products found under this parent category'], 404);
            }

            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch products by parent category'], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/products/filter",
     *     summary="Filter products by criteria",
     *     tags={"Products"},
     *     operationId="filterProducts",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="category_id", type="integer", description="Category ID"),
     *             @OA\Property(property="min_price", type="number", format="float", description="Minimum price"),
     *             @OA\Property(property="max_price", type="number", format="float", description="Maximum price"),
     *             @OA\Property(property="brand", type="string", description="Brand name")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of filtered products retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function filterProduct(Request $request)
    {
        $query = Product::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('min_price')) {
            $query->where('product_price', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price')) {
            $query->where('product_price', '<=', $request->input('max_price'));
        }

        if ($request->has('brand')) {
            $query->where('brand_id', $request->input('brand'));
        }

        $query->where('status', 1); // Ensure product is active

        $products = $query->get();

        return response()->json($products);
    }


}


