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
     *         description="Review created successfully"
     *     )
     * )
     */
    public function store(Request $request, $hotel_id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = HotelReview::create([
            'hotel_id' => $hotel_id,
            'user_id' => $user->id,
            'rating' => $request->rating,
            'review' => $request->comment,
        ]);

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
     *         description="List of reviews"
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
     *         description="List of reviews for the featured room"
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