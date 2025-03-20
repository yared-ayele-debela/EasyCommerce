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
     *     summary="Get all notifications",
     *     tags={"Notifications"},
     *     operationId="getNotifications",
     *     security={{"bearerAuth":{}}},
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
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-20T12:34:56Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function index()
    {
        return response()->json(Notification::orderBy('created_at', 'desc')->get());
    }
}
