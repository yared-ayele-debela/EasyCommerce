<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelPhoto;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Hotel",
 *     description="API Endpoints for managing foods"
 * )
 */
class HotelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/hotels",
     *     tags={"Hotel"},
     *     summary="Get a list of hotels",
     *     @OA\Response(response=200, description="List of hotels")
     * )
     */
    public function hotelIndex()
    {
        try {
            $hotels = Hotel::all();
            return response()->json($hotels);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve hotels'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/hotels",
     *     tags={"Hotel"},
     *     summary="Create a new hotel",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="location", type="string"),
     *             @OA\Property(property="latitude", type="number", format="float"),
     *             @OA\Property(property="longitude", type="number", format="float"),
     *             @OA\Property(property="price_per_night", type="number", format="float"),
     *             @OA\Property(property="banner_image", type="string"),
     *             @OA\Property(property="rating", type="number", format="float"),
     *             @OA\Property(property="is_advert", type="boolean"),
     *             @OA\Property(property="reviews_count", type="integer"),
     *             @OA\Property(property="discount", type="number", format="float"),
     *             @OA\Property(property="amenities", type="object"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Hotel created successfully")
     * )
     */
    public function hotelStore(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'category_id' => 'nullable|integer',
                'location' => 'required|string|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'price_per_night' => 'required|numeric',
                'banner_image' => 'nullable|string|max:255',
                'rating' => 'nullable|numeric',
                'is_advert' => 'nullable|boolean',
                'reviews_count' => 'nullable|integer',
                'discount' => 'nullable|numeric',
                'amenities' => 'nullable|json',
                'phone' => 'nullable|string|max:20',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $hotel = Hotel::create($request->all());
            return response()->json($hotel, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create hotel'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/{id}",
     *     tags={"Hotel"},
     *     summary="Get a hotel by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Hotel details")
     * )
     */
    public function hotelShow($id)
    {
        try {
            $hotel = Hotel::findOrFail($id);
            return response()->json($hotel);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hotel not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/hotels/{id}",
     *     tags={"Hotel"},
     *     summary="Update a hotel",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true
     *     ),
     *     @OA\Response(response=200, description="Hotel updated successfully")
     * )
     */
    public function hotelUpdate(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'category_id' => 'nullable|integer',
                'location' => 'required|string|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'price_per_night' => 'required|numeric',
                'banner_image' => 'nullable|string|max:255',
                'rating' => 'nullable|numeric',
                'is_advert' => 'nullable|boolean',
                'reviews_count' => 'nullable|integer',
                'discount' => 'nullable|numeric',
                'amenities' => 'nullable|json',
                'phone' => 'nullable|string|max:20',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $hotel = Hotel::findOrFail($id);
            $hotel->update($request->all());
            return response()->json($hotel);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update hotel'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/hotels/{id}",
     *     tags={"Hotel"},
     *     summary="Delete a hotel",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Hotel deleted successfully")
     * )
     */
    public function hotelDestroy($id)
    {
        try {
            $hotel = Hotel::findOrFail($id);
            $hotel->delete();
            return response()->json(['message' => 'Hotel deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete hotel'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/hotels/{hotel_id}/photos",
     *     tags={"Hotel"},
     *     summary="Upload photos for a hotel",
     *     @OA\Parameter(
     *         name="hotel_id",
     *         in="path",
     *         required=true,
     *         description="ID of the hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"photos"},
     *                 @OA\Property(
     *                     property="photos",
     *                     type="array",
     *                     @OA\Items(type="string", format="binary")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Photos uploaded successfully")
     * )
     */
    public function uploadPhotos(Request $request, $hotel_id)
    {
        try {
            // Validate the request to ensure it contains files
            $request->validate([
                'photos' => 'required|array',
                'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Adjust file types and size as needed
            ]);

            // Find the hotel by ID
            $hotel = Hotel::findOrFail($hotel_id);

            // Store the uploaded photos
            $photoPaths = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('hotel_photos', 'public'); // Store in 'public/hotel_photos' directory
                    $photoPaths[] = $path;
                }
            }

            // Associate the photos with the hotel (assuming you have a photos table or similar)
            // Example: $hotel->photos()->create(['path' => $path]);

            return response()->json(['message' => 'Photos uploaded successfully', 'paths' => $photoPaths], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to upload photos'], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/hotels/{hotel_id}/rooms",
     *     tags={"Hotel"},
     *     summary="Get rooms for a hotel",
     *     @OA\Parameter(
     *         name="hotel_id",
     *         in="path",
     *         required=true,
     *         description="ID of the hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="List of rooms")
     * )
     */
    public function getRooms($hotel_id)
    {
        try {
            // Find the hotel by ID
            $hotel = Hotel::findOrFail($hotel_id);

            // Assuming you have a relationship defined in the Hotel model
            // Example: public function rooms() { return $this->hasMany(Room::class); }
            $rooms = $hotel->rooms;

            return response()->json($rooms);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve rooms'], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/hotels/{hotel_id}/rooms/{room_id}",
     *     tags={"Hotel"},
     *     summary="Get room details",
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
     *     @OA\Response(response=200, description="Room details")
     * )
     */
    public function getRoomDetails($hotel_id, $room_id)
    {
        try {
            // Find the hotel by ID
            $hotel = Hotel::findOrFail($hotel_id);

            // Assuming you have a relationship defined in the Hotel model
            // Example: public function rooms() { return $this->hasMany(Room::class); }
            $room = $hotel->rooms()->findOrFail($room_id);

            return response()->json($room);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Room not found or does not belong to the specified hotel'], 404);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/hotels/{hotel_id}/rooms/{room_id}/availability",
     *     tags={"Hotel"},
     *     summary="Check room availability",
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
     *     @OA\Parameter(
     *         name="check_in",
     *         in="query",
     *         required=true,
     *         description="Check-in date",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="check_out",
     *         in="query",
     *         required=true,
     *         description="Check-out date",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(response=200, description="Room availability status")
     * )
     */
    public function checkRoomAvailability(Request $request, $hotel_id, $room_id)
    {
        try {
            // Validate the request to ensure it contains check-in and check-out dates
            $request->validate([
                'check_in' => 'required|date',
                'check_out' => 'required|date|after:check_in',
            ]);

            $checkIn = $request->input('check_in');
            $checkOut = $request->input('check_out');

            // Find the hotel by ID
            $hotel = Hotel::findOrFail($hotel_id);

            // Check if the room belongs to the hotel
            $room = $hotel->rooms()->findOrFail($room_id);

            // Check if the room is available for the given date range
            $isAvailable = !Reservation::where('room_id', $room_id)
                ->where(function ($query) use ($checkIn, $checkOut) {
                    $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                        ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                        ->orWhere(function ($query) use ($checkIn, $checkOut) {
                            $query->where('check_in_date', '<=', $checkIn)
                                    ->where('check_out_date', '>=', $checkOut);
                        });
                })
                ->exists();

            return response()->json(['available' => $isAvailable]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to check room availability'], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/hotels/{hotel_id}/rooms/{room_id}/photos",
     *     tags={"Hotel"},
     *     summary="Get hotel photos",
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
     *     @OA\Response(response=200, description="List of hotel photos")
     * )
     */
    public function getRoomPhotos($hotel_id, $room_id)
    {
        try {
            // Find the hotel by ID
            $hotel = Hotel::findOrFail($hotel_id);

            // Check if the room belongs to the hotel
            $room = $hotel->rooms()->findOrFail($room_id);

            // Retrieve photos associated with the hotel
            $photos = HotelPhoto::where('hotel_id', $hotel_id)->get();

            return response()->json($photos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve hotel photos'], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/hotels/{hotel_id}/rooms/{room_id}/amenities",
     *     tags={"Hotel"},
     *     summary="Get hotel amenities",
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
     *     @OA\Response(response=200, description="List of hotel amenities")
     * )
     */
    public function getRoomAmenities($hotel_id, $room_id)
    {
        try {
            // Find the hotel by ID
            $hotel = Hotel::findOrFail($hotel_id);

            // Check if the room belongs to the hotel
            $room = $hotel->rooms()->findOrFail($room_id);

            // Retrieve amenities associated with the hotel
            $amenities = $hotel->amenities()->get();

            return response()->json($amenities);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve hotel amenities'], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/hotels/{hotel_id}/rooms/{room_id}/similar",
     *     tags={"Hotel"},
     *     summary="Get similar rooms",
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
     *     @OA\Response(response=200, description="List of similar rooms")
     * )
     */
    public function getSimilarRooms($hotel_id, $room_id)
    {
        try {
            // Find the hotel by ID
            $hotel = Hotel::findOrFail($hotel_id);

            // Check if the room belongs to the hotel
            $room = $hotel->rooms()->findOrFail($room_id);

            // Define similarity criteria (e.g., price range and amenities)
            $priceRange = 50; // Adjust the price range as needed
            $roomPrice = $room->price_per_night;

            // Retrieve similar rooms based on price range and amenities
            $similarRooms = Room::where('hotel_id', $hotel_id)
                ->where('id', '!=', $room_id)
                ->whereBetween('price_per_night', [$roomPrice - $priceRange, $roomPrice + $priceRange])
                ->get();

            return response()->json($similarRooms);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve similar rooms'], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/hotels/{hotel_id}/rooms/{room_id}/bookings",
     *     tags={"Hotel"},
     *     summary="Get room bookings",
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
     *     @OA\Response(response=200, description="List of room bookings")
     * )
     */
    public function getRoomBookings($hotel_id, $room_id)
    {
        try {
            // Find the hotel by ID
            $hotel = Hotel::findOrFail($hotel_id);

            // Check if the room belongs to the hotel
            $room = $hotel->rooms()->findOrFail($room_id);

            // Retrieve bookings associated with the room
            $bookings = Reservation::where('room_id', $room_id)->get();

            return response()->json($bookings);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve room bookings'], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/hotels/banners",
     *     tags={"Hotel"},
     *     summary="Get active banners",
     *     @OA\Response(response=200, description="List of active banners")
     * )
     */
    public function getActiveBanners()
    {
        try {
            // Retrieve hotels that are marked as advertisements
            $activeBanners = Hotel::where('is_advert', 1)
                ->select('id', 'name', 'banner_image')
                ->get();

            return response()->json($activeBanners);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve active banners'], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/hotels/search",
     *     tags={"Hotel"},
     *     summary="Search for hotels",
     *     @OA\Parameter(
     *         name="location",
     *         in="query",
     *         required=false,
     *         description="Location to filter hotels",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="min_price",
     *         in="query",
     *         required=false,
     *         description="Minimum price per night",
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *         name="max_price",
     *         in="query",
     *         required=false,
     *         description="Maximum price per night",
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *         name="rating",
     *         in="query",
     *         required=false,
     *         description="Minimum rating",
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *         name="amenities",
     *         in="query",
     *         required=false,
     *         description="Comma-separated list of amenity IDs",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         required=false,
     *         description="Category ID to filter hotels",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Search results")
     * )
     */
    public function hotelSearch(Request $request)
    {
        try {
            $query = Hotel::query();

            // Filter by location
            if ($request->has('location')) {
                $location = $request->input('location');
                $query->where('location', 'like', "%{$location}%");
            }

            // Filter by price range
            if ($request->has('min_price')) {
                $query->where('price_per_night', '>=', $request->input('min_price'));
            }
            if ($request->has('max_price')) {
                $query->where('price_per_night', '<=', $request->input('max_price'));
            }

            // Filter by rating
            if ($request->has('rating')) {
                $query->where('rating', '>=', $request->input('rating'));
            }

            // Filter by amenities
            if ($request->has('amenities')) {
                $amenityIds = explode(',', $request->input('amenities'));
                $query->whereHas('amenities', function ($q) use ($amenityIds) {
                    $q->whereIn('amenity_id', $amenityIds);
                });
            }

            // Filter by category
            if ($request->has('category_id')) {
                $query->where('category_id', $request->input('category_id'));
            }

            $results = $query->get();

            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to search hotels'], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/hotels/categories",
     *     tags={"Hotel"},
     *     summary="Get hotel categories",
     *     @OA\Response(response=200, description="List of hotel categories")
     * )
     */
    public function getCategories()
    {
        try {
            $categories = Category::all();
            return response()->json(['categories' => $categories], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch categories'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/categories/{category_id}",
     *     tags={"Hotel"},
     *     summary="Get hotels by category",
     *     @OA\Parameter(
     *         name="category_id",
     *         in="path",
     *         required=true,
     *         description="ID of the category",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="List of hotels in the category")
     * )
     */
    public function getHotelsByCategory($category_id)
    {
        try {
            $validatedData = request()->validate([
                'category_id' => 'required|integer|exists:categories,id'
            ]);

            $hotels = Hotel::where('category_id', $validatedData['category_id'])->get();
            return response()->json(['hotels' => $hotels], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch hotels'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/locations",
     *     tags={"Hotel"},
     *     summary="Get hotel locations",
     *     @OA\Response(response=200, description="List of hotel locations")
     * )
     */
    public function getLocations()
    {
        try {
            $locations = Hotel::distinct()->pluck('location');
            return response()->json(['locations' => $locations], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch locations'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/locations/{location}",
     *     tags={"Hotel"},
     *     summary="Get hotels by location",
     *     @OA\Parameter(
     *         name="location",
     *         in="path",
     *         required=true,
     *         description="Location of the hotels",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="List of hotels in the location")
     * )
     */
    public function getHotelsByLocation($location)
    {
        try {
            $validatedData = request()->validate([
                'location' => 'required|string|exists:hotels,location'
            ]);

            $hotels = Hotel::where('location', $validatedData['location'])->get();
            return response()->json(['hotels' => $hotels], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch hotels'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/amenities",
     *     tags={"Hotel"},
     *     summary="Get hotel amenities",
     *     @OA\Response(response=200, description="List of hotel amenities")
     * )
     */
    public function getAmenities()
    {
        return response()->json(['amenities' => ['WiFi', 'Pool', 'Spa', 'Gym']]);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/amenities/{amenity}",
     *     tags={"Hotel"},
     *     summary="Get hotels by amenity",
     *     @OA\Parameter(
     *         name="amenity",
     *         in="path",
     *         required=true,
     *         description="Amenity of the hotels",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="List of hotels with the amenity")
     * )
     */
    public function getHotelsByAmenity($amenity)
    {
        $hotels = Hotel::whereJsonContains('amenities', $amenity)->get();
        return response()->json($hotels);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/featured",
     *     tags={"Hotel"},
     *     summary="Get featured hotels",
     *     @OA\Response(response=200, description="List of featured hotels")
     * )
     */
    public function getFeaturedHotels()
    {
        $hotels = Hotel::where('is_featured', true)->get();
        return response()->json($hotels);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/featured/{hotel_id}",
     *     tags={"Hotel"},
     *     summary="Get featured hotel details",
     *     @OA\Parameter(
     *         name="hotel_id",
     *         in="path",
     *         required=true,
     *         description="ID of the featured hotel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Featured hotel details")
     * )
     */
    public function getFeaturedHotelDetails($hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);
        return response()->json($hotel);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/featured/{hotel_id}/rooms",
     *     tags={"Hotel"},
     *     summary="Get rooms for a featured hotel",
     *     @OA\Response(response=200, description="List of rooms for the featured hotel")
     * )
     */
    public function getFeaturedHotelRooms($hotel_id)
    {
        $rooms = Room::where('hotel_id', $hotel_id)->get();
        return response()->json($rooms);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/featured/{hotel_id}/rooms/{room_id}",
     *     tags={"Hotel"},
     *     summary="Get featured hotel room details",
     *     @OA\Response(response=200, description="Featured hotel room details")
     * )
     */
    public function getFeaturedHotelRoomDetails($hotel_id, $room_id)
    {
        $room = Room::where('hotel_id', $hotel_id)->findOrFail($room_id);
        return response()->json($room);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/featured/{hotel_id}/rooms/{room_id}/availability",
     *     tags={"Hotel"},
     *     summary="Check featured hotel room availability",
     *     @OA\Response(response=200, description="Featured hotel room availability status")
     * )
     */
    public function checkFeaturedHotelRoomAvailability($hotel_id, $room_id)
    {
        $room = Room::where('hotel_id', $hotel_id)->findOrFail($room_id);
        return response()->json(['availability' => $room->is_available]);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/featured/{hotel_id}/rooms/{room_id}/photos",
     *     tags={"Hotel"},
     *     summary="Get featured hotel room photos",
     *     @OA\Response(response=200, description="List of featured hotel room photos")
     * )
     */
    public function getFeaturedHotelRoomPhotos($hotel_id, $room_id)
    {
        $room = Room::where('hotel_id', $hotel_id)->findOrFail($room_id);
        return response()->json(['photos' => $room->photos]);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/featured/{hotel_id}/rooms/{room_id}/amenities",
     *     tags={"Hotel"},
     *     summary="Get featured hotel room amenities",
     *     @OA\Response(response=200, description="List of featured hotel room amenities")
     * )
     */
    public function getFeaturedHotelRoomAmenities($hotel_id, $room_id)
    {
        $room = Room::where('hotel_id', $hotel_id)->findOrFail($room_id);
        return response()->json(['amenities' => $room->amenities]);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/featured/{hotel_id}/rooms/{room_id}/similar",
     *     tags={"Hotel"},
     *     summary="Get similar featured hotel rooms",
     *     @OA\Response(response=200, description="List of similar featured hotel rooms")
     * )
     */
    public function getSimilarFeaturedHotelRooms($hotel_id, $room_id)
    {
        $room = Room::where('hotel_id', $hotel_id)
                    ->where('id', '!=', $room_id)
                    ->get();
        return response()->json($room);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/featured/{hotel_id}/rooms/{room_id}/bookings",
     *     tags={"Hotel"},
     *     summary="Get featured hotel room bookings",
     *     @OA\Response(response=200, description="List of featured hotel room bookings")
     * )
     */
    public function getFeaturedHotelRoomBookings($hotel_id, $room_id)
    {
        $room = Room::where('hotel_id', $hotel_id)->findOrFail($room_id);
        return response()->json(['bookings' => $room->bookings]);
    }
}
