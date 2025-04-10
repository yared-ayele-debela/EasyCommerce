<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\State;
use App\Models\SubCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('category')->latest()->get();
        $categories = HotelCategory::all();
        $amenities = Amenity::all();
        $cities=City::all();
        $countries=Country::all();
        // dd($countries);
        $states=State::all();
        return view('hotel.dashboard.hotels.index', compact('hotels', 'categories','amenities','cities','states','countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:hotel_categories,id',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'price_per_night' => 'required|numeric',
            'banner_image' => 'nullable|image',
            'is_adverted' => 'nullable|boolean',
            'discount' => 'nullable|numeric',
            'is_featured' => 'nullable|boolean',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
        ]);
        // dd($request->all());

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('hotels', 'public');
        }


        Hotel::create($validated);

        return redirect()->back()->with('success', 'Hotel created successfully!');
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $validated = $request->validate([
           'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:hotel_categories,id',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'price_per_night' => 'required|numeric',
            'banner_image' => 'nullable|image',
            'is_adverted' => 'nullable|boolean',
            'discount' => 'nullable|numeric',
            'is_featured' => 'nullable|boolean',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
        ]);

        if ($request->hasFile('banner_image')) {
            if ($hotel->banner_image && Storage::disk('public')->exists($hotel->banner_image)) {
                Storage::disk('public')->delete($hotel->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('hotels', 'public');
        }



        $hotel->update($validated);

        return redirect()->back()->with('success', 'Hotel updated successfully!');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        if ($hotel->banner_image && Storage::disk('public')->exists($hotel->banner_image)) {
            Storage::disk('public')->delete($hotel->banner_image);
        }
        $hotel->delete();
        return redirect()->back()->with('success', 'Hotel deleted!');
    }

    public function toggleAdvertise($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->is_adverted = !$hotel->is_adverted;
        $hotel->save();

        return redirect()->back()->with('success', 'Hotel advertisement status updated!');
    }
    public function toggleFeatured($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->is_featured = !$hotel->is_featured;
        $hotel->save();

        return redirect()->back()->with('success', 'Hotel featured status updated!');
    }


    public function my_hotel(Request $request){

        $hotel= Hotel::with(['photos','rooms.images'])->where('id',$request->id)->where('admin_id',Auth::guard('admin')->user()->id)->first();
        if($hotel){
            $categories = HotelCategory::all();
            $amenities = Amenity::all();

            return view('Hotel.dashboard.hotels.my_hotel.index', compact('hotel', 'categories','amenities'));
        }else{

            Alert::toast('Something was wrong','error');
            return redirect()->back();
        }

    }
}