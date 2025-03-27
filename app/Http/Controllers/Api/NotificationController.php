<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Notifications",
 *     description="API Endpoints for managing notifications"
 * )
 */
class NotificationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/notifications",
    *     summary="Get notifications for the authenticated user",
    *     tags={"Notifications"},
    *     operationId="getUserNotifications",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         name="user_id",
    *         in="query",
    *         required=true,
    *         description="ID of the user to fetch notifications for",
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *     @OA\Parameter(
    *         name="is_read",
    *         in="query",
    *         required=false,
    *         description="Filter notifications by read status (0 for unread, 1 for read)",
    *         @OA\Schema(type="integer", enum={0, 1}, example=0)
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="List of notifications retrieved successfully",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(
    *                 type="object",
    *                 @OA\Property(property="id", type="integer", example=1),
    *                 @OA\Property(property="title", type="string", example="New Order Received"),
    *                 @OA\Property(property="message", type="string", example="You have a new order from John Doe"),
    *                 @OA\Property(property="is_read", type="boolean", example=false),
    *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-20T12:34:56Z")
    *             )
    *         )
    *     ),
    *     @OA\Response(response=401, description="Unauthorized"),
    *     @OA\Response(response=404, description="User not found"),
    *     @OA\Response(response=500, description="Server error")
    * )
    */
    public function index()
    {
       $user = auth()->user();

       if (!$user) {
          return response()->json(['error' => 'Unauthorized'], 401);
       }

       $query = Notification::where('user_id', $user->id);
    
        $query->where('is_read', true);

       $notifications = $query->orderBy('created_at', 'desc')->get();

       return response()->json($notifications);
    }
}
