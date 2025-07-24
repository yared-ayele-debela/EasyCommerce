<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\Roles;
use App\Models\State;
use App\Models\SubCity;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class HotelController extends Controller
{

      public function __construct()
    {
        $this->middleware('admin.permission:view_hotel_hotel')->only('index');
        $this->middleware('admin.permission:add_hotel_hotel')->only('store');
        $this->middleware('admin.permission:edit_hotel_hotel')->only(methods: 'update');
        $this->middleware('admin.permission:delete_hotel_hotel')->only('destroy');
    }
    public function index()
    {
        $adminType = Auth::guard('admin')->user()->type;

        $role=Roles::where('name',$adminType)->first();

        $group = $role->group ?? null;

        if ($group === "general") {

            $hotels = Hotel::with('category')->latest()->get();
        }else{
            $hotels = Hotel::with('category')->where('admin_id',Auth::guard('admin')->user()->id)->latest()->get();
        }

        $categories = HotelCategory::all();
        $amenities = Amenity::all();
        $cities=City::all();
        $countries=Country::all();
        // dd($countries);
        $states=State::all();
        return view('Hotel.dashboard.hotels.index', compact('hotels', 'categories','amenities','cities','states','countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admin_id' => 'nullable|exists:admins,id',
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
            $path = $request->file('banner_image')->store('hotels', 'public');
            $validated['banner_image'] = asset('storage/' . $path);
        }

        $validated['admin_id'] = Auth::guard('admin')->user()->id;


        Hotel::create($validated);


         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Add Category', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


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
            // Remove the old image file if it exists
            $oldPath = str_replace(asset('storage/') . '/', '', $hotel->banner_image);
            if ($hotel->banner_image && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Store the new file and save its full URL
            $path = $request->file('banner_image')->store('hotels', 'public');
            $validated['banner_image'] = asset('storage/' . $path);
        }

        $hotel->update($validated);

          $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Update Hotel', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        return redirect()->back()->with('success', 'Hotel updated successfully!');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        // Extract relative path from full URL
        $bannerImagePath = $hotel->banner_image
            ? str_replace(asset('storage') . '/', '', $hotel->banner_image)
            : null;
        // Delete image if it exists in storage
        if ($bannerImagePath && Storage::disk('public')->exists($bannerImagePath)) {
            Storage::disk('public')->delete($bannerImagePath);
        }

        // Delete hotel record
        $hotel->delete();

          $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Delete Hotel', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

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
