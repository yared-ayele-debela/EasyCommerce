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
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\HotelController;
// use App\Http\Controllers\Api\ReviewController;



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
// Banner routes
Route::prefix('banners')->group(function () {
    Route::get('active', [BannerController::class, 'fetchActiveBanners']);
});
// Guest Routes (Accessible without authentication)
Route::get('/foods', [FoodController::class, 'index']);
Route::get('/foods/special-offers', [FoodController::class, 'specialOffers']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/restaurants/nearby', [RestaurantController::class, 'nearbyRestaurants']);
Route::delete('/delivery-addresses/{id}', [DeliveryAddressController::class, 'destroy'])->middleware('auth:sanctum');
// Food Category routes
Route::get('/foods/category', [FoodController::class, 'category']);
Route::get('/foods/category/{categoryId}', [FoodController::class, 'getFoodsByCategory']);
// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Restaurant
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
// ================Hotel=================
Route::get('hotels', [HotelController::class, 'hotelIndex']);
Route::post('hotels', [HotelController::class, 'hotelStore']);
Route::get('hotels/{id}', [HotelController::class, 'hotelShow']);
Route::put('hotels/{id}', [HotelController::class, 'hotelUpdate']);
Route::delete('hotels/{id}', [HotelController::class, 'hotelDestroy']);


Route::post('hotels/{hotel_id}/photos', [HotelController::class, 'uploadPhotos']);
Route::get('hotels/{hotel_id}/rooms', [HotelController::class, 'getRooms']);
Route::get('hotels/{hotel_id}/rooms/{room_id}', [HotelController::class, 'getRoomDetails']);
Route::get('hotels/{hotel_id}/rooms/{room_id}/availability', [HotelController::class, 'checkRoomAvailability']);
Route::get('hotels/{hotel_id}/rooms/{room_id}/photos', [HotelController::class, 'getRoomPhotos']);
Route::get('hotels/{hotel_id}/rooms/{room_id}/amenities', [HotelController::class, 'getRoomAmenities']);
Route::get('hotels/{hotel_id}/rooms/{room_id}/similar', [HotelController::class, 'getSimilarRooms']);
Route::get('hotels/{hotel_id}/rooms/{room_id}/bookings', [HotelController::class, 'getRoomBookings']);
Route::get('hotels/{hotel_id}/rooms/{room_id}/availability', [HotelController::class, 'checkRoomAvailability']);


Route::get('/hotels/banners', [HotelController::class, 'getActiveBanners']);
Route::get('/hotels/search', [HotelController::class, 'hotelSearch']);
Route::get('/hotels/categories', [HotelController::class, 'getCategories']);
Route::get('/hotels/categories/{category_id}', [HotelController::class, 'getHotelsByCategory']);
Route::get('/hotels/locations', [HotelController::class, 'getLocations']);
Route::get('/hotels/locations/{location}', [HotelController::class, 'getHotelsByLocation']);
Route::get('/hotels/amenities', [HotelController::class, 'getAmenities']);
Route::get('/hotels/amenities/{amenity}', [HotelController::class, 'getHotelsByAmenity']);
Route::get('/hotels/featured', [HotelController::class, 'getFeaturedHotels']);
Route::get('/hotels/featured/{hotel_id}', [HotelController::class, 'getFeaturedHotelDetails']);
Route::get('/hotels/featured/{hotel_id}/rooms', [HotelController::class, 'getFeaturedHotelRooms']);
Route::get('/hotels/featured/{hotel_id}/rooms/{room_id}', [HotelController::class, 'getFeaturedHotelRoomDetails']);
Route::get('/hotels/featured/{hotel_id}/rooms/{room_id}/availability', [HotelController::class, 'checkFeaturedHotelRoomAvailability']);
Route::get('/hotels/featured/{hotel_id}/rooms/{room_id}/photos', [HotelController::class, 'getFeaturedHotelRoomPhotos']);
Route::get('/hotels/featured/{hotel_id}/rooms/{room_id}/amenities', [HotelController::class, 'getFeaturedHotelRoomAmenities']);
Route::get('/hotels/featured/{hotel_id}/rooms/{room_id}/similar', [HotelController::class, 'getSimilarFeaturedHotelRooms']);
Route::get('/hotels/featured/{hotel_id}/rooms/{room_id}/bookings', [HotelController::class, 'getFeaturedHotelRoomBookings']);
Route::get('/hotels/featured/{hotel_id}/rooms/{room_id}/availability', [HotelController::class, 'checkFeaturedHotelRoomAvailability']);
Route::get('/hotels/featured/{hotel_id}/rooms/{room_id}/bookings', [HotelController::class, 'getFeaturedHotelRoomBookings']);

Route::post('hotels/{hotel_id}/reviews', [HotelReviewController::class, 'store']);
Route::get('hotels/{hotel_id}/reviews', [HotelReviewController::class, 'show']);
Route::get('/hotels/featured/{hotel_id}/rooms/{room_id}/reviews', [HotelReviewController::class, 'getFeaturedHotelRoomReviews']);
Route::post('reservations', [ReservationController::class, 'store']);
Route::get('users/{user_id}/reservations', [ReservationController::class, 'userReservations']);
Route::put('reservations/{id}/cancel', [ReservationController::class, 'cancel']);
Route::get('hotels/{hotel_id}/rooms/{room_id}/reviews', [ReviewController::class, 'getRoomReviews']);
