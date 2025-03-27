<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\UserProfileController;
// ================================
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\RestaurantCategoryController;
use App\Http\Controllers\Api\RestaurantOrderController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\DeliveryAddressController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\DashboardController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// User route for authenticated user details
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication routes
// Route::prefix('auth')->group(function () {
//     Route::post('login', [AuthController::class, 'login']);
//     Route::post('register', [AuthController::class, 'register']);
//     Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// });

Route::prefix('auth')->group(function () {

    // User Routes
    Route::post('user/register', [AuthController::class, 'Register']);
    Route::post('user/login', [AuthController::class, 'Login']);
    Route::post('user/forgot-password', [AuthController::class, 'forgetPassword']);
    Route::post('user/reset-password', [AuthController::class, 'resetPassword']);
    
    // Restaurant Routes
    Route::post('restaurant/register', [AuthController::class, 'registerRestaurant']);
    Route::post('restaurant/login', [AuthController::class, 'loginRestaurant']);
    
    // Logout Route (for both user and restaurant)
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
// Category routes
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
});

// Product routes
Route::prefix('products')->group(function () {
    Route::get('deal-of-the-day', [ProductController::class, 'dealOfTheDay']);
    Route::get('trending', [ProductController::class, 'trending']);
    Route::get('latest', [ProductController::class, 'latest']);
    Route::get('new-arrivals', [ProductController::class, 'newArrivals']);
    Route::get('sponsored', [ProductController::class, 'sponsored']);
    Route::get('search', [ProductController::class, 'search']);
    Route::get('{id}/similar', [ProductController::class, 'similar']);
    Route::get('{id}', [ProductController::class, 'detail']);
});

// Cart routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('add', [CartController::class, 'add']);
    Route::post('remove', [CartController::class, 'remove']);
    Route::post('update', [CartController::class, 'update']);
});

// Checkout routes
Route::prefix('checkout')->group(function () {
    Route::post('/', [CheckoutController::class, 'process']);
});

// Payment routes
Route::prefix('payment')->group(function () {
    Route::post('initiate', [PaymentController::class, 'initiate']);
    Route::post('verify', [PaymentController::class, 'verify']);
});

// Order routes
Route::prefix('orders')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('{id}', [OrderController::class, 'detail']);
    Route::post('cancel/{id}', [OrderController::class, 'cancel']);
});

// Wishlist routes
Route::prefix('wishlist')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [WishlistController::class, 'index']);
    Route::post('add', [WishlistController::class, 'add']);
    Route::post('remove', [WishlistController::class, 'remove']);
});

// Review routes
Route::prefix('reviews')->middleware('auth:sanctum')->group(function () {
    Route::post('add', [ReviewController::class, 'add']);
    Route::get('{productId}', [ReviewController::class, 'index']);
});

// Address management
Route::prefix('addresses')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [AddressController::class, 'index']);
    Route::post('add', [AddressController::class, 'add']);
    Route::post('update/{id}', [AddressController::class, 'update']);
    Route::post('delete/{id}', [AddressController::class, 'delete']);
});

// User profile
Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('profile', [UserProfileController::class, 'profile']);
    Route::post('update', [UserProfileController::class, 'update']);
});

Route::get('/restaurant-categories', [RestaurantCategoryController::class, 'index']);
// ================================Restaurant========

// Guest Routes (Accessible without authentication)
Route::get('/foods', [FoodController::class, 'index']);
Route::get('/foods/special-offers', [FoodController::class, 'specialOffers']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/restaurants/nearby', [RestaurantController::class, 'nearbyRestaurants']);

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Require Authentication)
Route::middleware('auth:sanctum')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Orders
    Route::get('/orders/running', [RestaurantOrderController::class, 'runningOrders']);
    Route::get('/orders/requests', [RestaurantOrderController::class, 'orderRequests']);
    Route::post('/orders', [RestaurantOrderController::class, 'store']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);

    // Delivery Addresses
    Route::get('/delivery-addresses', [DeliveryAddressController::class, 'index']);
    Route::post('/delivery-addresses', [DeliveryAddressController::class, 'store']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});