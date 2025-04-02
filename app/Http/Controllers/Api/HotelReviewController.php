<?php

namespace App\Http\Controllers\Api;

use App\Models\HotelReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HotelReviewController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/hotels/{hotel_id}/reviews",
     *     summary="Create a new review for a hotel",
     *     tags={"Hotel Reviews"},
     *     @OA\Parameter(
     *         name="hotel_id",
     *         in="path",
     *         required=true,
     *         description="ID of the hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="rating", type="integer", example=5),
     *             @OA\Property(property="comment", type="string", example="Great hotel!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Review created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Review")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $review = HotelReview::create($request->all());
        return response()->json($review, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/{hotel_id}/reviews",
     *     summary="Get all reviews for a hotel",
     *     tags={"Hotel Reviews"},
     *     @OA\Parameter(
     *         name="hotel_id",
     *         in="path",
     *         required=true,
     *         description="ID of the hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of reviews",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Review"))
     *     )
     * )
     */
    public function show($hotel_id)
    {
        return response()->json(HotelReview::where('hotel_id', $hotel_id)->get());
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/featured/{hotel_id}/rooms/{room_id}/reviews",
     *     summary="Get reviews for a featured hotel room",
     *     tags={"Hotel Reviews"},
     *     @OA\Parameter(
     *         name="hotel_id",
     *         in="path",
     *         required=true,
     *         description="ID of the hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="room_id",
     *         in="path",
     *         required=true,
     *         description="ID of the room",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of reviews for the featured room",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Review"))
     *     )
     * )
     */
    public function getFeaturedHotelRoomReviews($hotel_id, $room_id)
    {
        // Example logic for fetching reviews for a featured hotel room
        $reviews = HotelReview::where('hotel_id', $hotel_id)
            ->where('room_id', $room_id)
            ->get();

        return response()->json($reviews);
    }
}