<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\HotelReview;
use App\Models\Room;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    //
    public function index($id){
        try{
            $hotel=Hotel::with('rooms')->findOrFail($id);
            // dd($hotel);
            $rooms=$hotel->rooms()->latest()->paginate(10);

            return view('Hotel.frontend.pages.hotel.detail',compact('hotel','rooms'));
        }catch(Exception $e){
            return redirect()->back();
        }
    }
    public function gallery($id){
        try{
        $hotel=Hotel::findOrFail($id);
        return view('Hotel.frontend.pages.hotel.gallery',compact('hotel'));
    }catch(Exception $e){
        return redirect()->back();
    }
    }

    public function select_date($id){

        $id=decrypt($id);
        $room=Room::with('images','amenities','hotel')->findOrFail($id);
        $av_rating=HotelReview::where('room_id',$room->id)->avg('rating');

        // dd($room);
        return view('Hotel.frontend.pages.room.select_date',compact('room','av_rating'));
    }

    public function discounted(){

        $hotels=Hotel::with('photos')->where('discount','>','0')->latest()->paginate(10);
        $name="Discounted Hotels";
        // dd($hotels);

        return view('Hotel.frontend.pages.hotel.index',compact('hotels','name'));
    }
    public function latest(){

        $cities=City::all();
        $countries=Country::all();
        // dd($countries);
        $states=State::all();
        $categories=HotelCategory::all();
        // dd($hotels);

        return view('Hotel.frontend.pages.hotel.search',compact('cities','countries','states','categories'));
    }

    public function nearby()
    {
        return view('Hotel.frontend.pages.hotel.nearby');
    }
    public function getNearbyHotels(Request $request)
{
    $latitude = $request->lat;
    $longitude = $request->lng;
    $radius = $request->radius ?? 100; // km

    $hotels = Hotel::select('*', DB::raw("
        (6371 * acos(
            cos(radians($latitude)) *
            cos(radians(latitude)) *
            cos(radians(longitude) - radians($longitude)) +
            sin(radians($latitude)) *
            sin(radians(latitude))
        )) AS distance
    "))
    ->having('distance', '<=', $radius)
    ->orderBy('distance')
    ->where('is_active', true)
    // ->take(8)
    ->get();

    $check_all=false;

    // Render partial blade view and return as HTML
    $html = view('Hotel.frontend.pages.hotel.partials.nearby-hotels', compact('hotels','check_all'))->render();

    return response()->json(['html' => $html]);
 }


    public function filter(Request $request)
    {
        // Filtering hotels based on provided parameters
        $hotels = Hotel::with('category')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->min_price, fn($q) => $q->where('price_per_night', '>=', $request->min_price))
            ->when($request->max_price, fn($q) => $q->where('price_per_night', '<=', $request->max_price))
            ->when($request->rating, fn($q) => $q->where('rating', '>=', $request->rating))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->country, fn($q) => $q->where('country', $request->country))
            ->when($request->state, fn($q) => $q->where('state', $request->state))
            ->when($request->city, fn($q) => $q->where('city', $request->city))
            ->when($request->location, fn($q) => $q->where('location', 'like', "%{$request->location}%"))
            ->when($request->is_featured, fn($q) => $q->where('is_featured', $request->is_featured))
            ->orderBy('price_per_night', 'desc') // Sorting by price descending
            ->get();

        return response()->json(['hotels' => $hotels]);
    }

}
