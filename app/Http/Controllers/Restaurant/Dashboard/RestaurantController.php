<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\Restaurant\Restaurant as RestaurantRestaurant;
use App\Models\Restaurant\RestaurantImage;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function index()
    {
        $adminType = Auth::guard('admin')->user()->type;
        if ($adminType === "Super Admin") {
            $restaurants = RestaurantRestaurant::with(['admin', 'images'])->latest()->get();
        } else {
            $restaurants = RestaurantRestaurant::with(['admin', 'images'])->where('admin_id', Auth::guard('admin')->user()->id)->latest()->get();
        }
        // $restaurants = RestaurantRestaurant::with(['admin', 'images'])->latest()->get();
        return view('restaurant.dashboard.restaurants.index', compact('restaurants'));
    }

    public function show(){
        $restaurant = RestaurantRestaurant::with(['admin', 'images'])->where('admin_id',Auth::guard('admin')->user()->id)->first();
        return view('restaurant.dashboard.restaurants.my-restaurants', compact('restaurant'));
    }
    /**
     * Store a newly created restaurant.
     */
    public function store(Request $request)
    {

        $request->validate([
            'admin_id'  => 'required|exists:users,id',
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:restaurants,email',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string',
            'cover_image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'logo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
            'images.*'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        // Upload Logo
        $logoPath = $request->file('logo') ? $request->file('logo')->store('restaurants', 'public') : null;
        $coverPath = $request->file('cover_image') ? $request->file('cover_image')->store('restaurants', 'public') : null;

        // Create Restaurant
        $restaurant = RestaurantRestaurant::create([
            'admin_id'  => $request->admin_id,
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'cover'     => $coverPath,
            'description'=>$request->description,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'logo'      => $logoPath,
            'is_active' => $request->is_active
        ]);

        // Upload and Save Multiple Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('restaurant_images', 'public');
                $restaurant->images()->create(['image_path' => $imagePath]);
            }
        }

        return redirect()->route('restaurants.index')->with('success', 'Restaurant created successfully.');
    }

    /**
     * Update the specified restaurant.
     */
    public function update(Request $request, RestaurantRestaurant $restaurant)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:restaurants,email,' . $restaurant->id,
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string',
            'cover_image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'logo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
            'images.*'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update restaurant details
        $restaurant->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'description'   => $request->description,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'is_active' => $request->is_active
        ]);

        // Update logo if a new one is uploaded
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($restaurant->logo) {
                Storage::disk('public')->delete($restaurant->logo);
            }
            // Store new logo
            $restaurant->logo = $request->file('logo')->store('restaurants', 'public');
            $restaurant->save();
        }
        if ($request->hasFile('cover_image')) {
            // Delete old cover_image if exists
            if ($restaurant->cover_image) {
                Storage::disk('public')->delete($restaurant->cover_image);
            }
            // Store new cover_image
            $restaurant->cover = $request->file('cover_image')->store('restaurants', 'public');
            $restaurant->save();
        }

        // Upload and Save New Multiple Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('restaurant_images', 'public');
                $restaurant->images()->create(['image_path' => $imagePath]);
            }
        }

        return redirect()->route('restaurants.index')->with('success', 'Restaurant updated successfully.');
    }

    /**
     * Remove the specified restaurant.
     */
    public function destroy(RestaurantRestaurant $restaurant)
    {
        // Delete logo
        if ($restaurant->logo) {
            Storage::disk('public')->delete($restaurant->logo);
        }
        // Delete logo
        if ($restaurant->cover_image) {
            Storage::disk('public')->delete($restaurant->cover_image);
        }
        // Delete multiple images
        foreach ($restaurant->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $restaurant->delete();
        return redirect()->route('restaurants.index')->with('success', 'Restaurant deleted successfully.');
    }

    public function deleteImage($id)
    {
        $image = RestaurantImage::findOrFail($id);

        // Delete image from storage
        Storage::disk('public')->delete($image->image_path);

        // Delete from database
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}