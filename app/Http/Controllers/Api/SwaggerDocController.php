<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;


// class SwaggerDocController extends Controller
// {
    /**
     * @OA\Tag(name="Products", description="Product management API")
     * @OA\Tag(name="Categories", description="Product category management")
     * @OA\Tag(name="Inventory", description="Product inventory management")
     */

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Get a list of products",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="List of products")
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Get a product by ID",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Product ID"
     *     ),
     *     @OA\Response(response=200, description="Product details"),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Create a new product",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "category_id"},
     *             @OA\Property(property="name", type="string", example="Product Name"),
     *             @OA\Property(property="price", type="number", example=19.99),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Product created"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Update a product by ID",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Product ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "category_id"},
     *             @OA\Property(property="name", type="string", example="Updated Product Name"),
     *             @OA\Property(property="price", type="number", example=29.99),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Product updated"),
     *     @OA\Response(response=404, description="Product not found"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Delete a product by ID",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Product ID"
     *     ),
     *     @OA\Response(response=200, description="Product deleted"),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    /**
     * @OA\Tag(name="Orders", description="Order management for food deliveries")
     * @OA\Tag(name="Notifications", description="User notifications management")
     * @OA\Tag(name="Categories", description="Food category management")
     * @OA\Tag(name="Restaurants", description="Restaurant information")
     */

    /**
     * @OA\Get(
     *     path="/api/orders/running",
     *     summary="Get running orders",
     *     tags={"Orders"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="List of running orders")
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Create a new order",
     *     tags={"Orders"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"restaurant_id", "delivery_address_id", "items"},
     *             @OA\Property(property="restaurant_id", type="integer", example=1),
     *             @OA\Property(property="delivery_address_id", type="integer", example=2),
     *             @OA\Property(property="items", type="array",
     *                 @OA\Items(
     *                     required={"food_id", "quantity", "price"},
     *                     @OA\Property(property="food_id", type="integer", example=10),
     *                     @OA\Property(property="quantity", type="integer", example=2),
     *                     @OA\Property(property="price", type="number", example=5.99)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Order created"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/notifications",
     *     summary="Get user-specific notifications",
     *     tags={"Notifications"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="List of notifications")
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/notifications",
     *     summary="Create a notification",
     *     tags={"Notifications"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "message"},
     *             @OA\Property(property="title", type="string", example="Order Update"),
     *             @OA\Property(property="message", type="string", example="Your order is on the way")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Notification created"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get all food categories",
     *     tags={"Categories"},
     *     @OA\Response(response=200, description="List of categories")
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/restaurants",
     *     summary="Get all restaurants",
     *     tags={"Restaurants"},
     *     @OA\Response(response=200, description="List of restaurants")
     * )
     */
// }
