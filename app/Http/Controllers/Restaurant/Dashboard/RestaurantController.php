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
        return view('Restaurant.dashboard.restaurants.index', compact('restaurants'));
    }

    public function show($Id){
        $id = decrypt($Id);
        $restaurant = RestaurantRestaurant::with(['admin', 'images'])->where('id',$id)->where('admin_id',Auth::guard('admin')->user()->id)->first();
        return view('Restaurant.dashboard.restaurants.my-restaurants', compact('restaurant'));
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
        $logoPath = null;
        $coverPath = null;

        if ($request->hasFile('logo')) {
            $logoStoredPath = $request->file('logo')->store('restaurants', 'public');
            $logoPath = asset('storage/' . $logoStoredPath); // Full URL
        }

        if ($request->hasFile('cover_image')) {
            $coverStoredPath = $request->file('cover_image')->store('restaurants', 'public');
            $coverPath = asset('storage/' . $coverStoredPath); // Full URL
        }

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
            'is_open' => $request->is_active
        ]);

        // Upload and Save Multiple Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $storedPath = $image->store('restaurant_images', 'public');
                $fullUrl = asset('storage/' . $storedPath);

                $restaurant->images()->create([
                    'image_path' => $fullUrl
                ]);
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
            'is_open' => $request->is_active
        ]);

        // Update logo if a new one is uploaded
        if ($request->hasFile('logo')) {
            if ($restaurant->logo) {
                // Delete old logo (convert URL to storage path if needed)
                $oldLogoPath = str_replace(asset('storage') . '/', '', $restaurant->logo);
                Storage::disk('public')->delete($oldLogoPath);
            }

            $logoPath = $request->file('logo')->store('restaurants', 'public');
            $restaurant->logo = asset('storage/' . $logoPath);
            $restaurant->save();
        }
        // Update cover image
        if ($request->hasFile('cover_image')) {
            if ($restaurant->cover_image) {
                $oldCoverPath = str_replace(asset('storage') . '/', '', $restaurant->cover_image);
                Storage::disk('public')->delete($oldCoverPath);
            }
            $coverPath = $request->file('cover_image')->store('restaurants', 'public');
            $restaurant->cover= asset('storage/' . $coverPath);
            $restaurant->save();
        }

        // Optionally delete old multiple images before uploading new ones
        if ($request->hasFile('images')) {
            foreach ($restaurant->images as $image) {
                $oldImagePath = str_replace(asset('storage') . '/', '', $image->image_path);
                Storage::disk('public')->delete($oldImagePath);
                $image->delete();
            }

            // Upload and Save New Multiple Images
            foreach ($request->file('images') as $image) {
                $path = $image->store('restaurant_images', 'public');
                $restaurant->images()->create([
                    'image_path' => asset('storage/' . $path)
                ]);
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
        $logoPath = str_replace(asset('storage') . '/', '', $restaurant->logo);
        Storage::disk('public')->delete($logoPath);
    }

    // Delete cover image
    if ($restaurant->cover_image) {
        $coverPath = str_replace(asset('storage') . '/', '', $restaurant->cover_image);
        Storage::disk('public')->delete($coverPath);
    }

    // Delete multiple images
    foreach ($restaurant->images as $image) {
        $imagePath = str_replace(asset('storage') . '/', '', $image->image_path);
        Storage::disk('public')->delete($imagePath);
        $image->delete();
    }

    $restaurant->delete();

    return redirect()->route('restaurants.index')->with('success', 'Restaurant deleted successfully.');
}

public function deleteImage($id)
{
    $image = RestaurantImage::findOrFail($id);

    $imagePath = str_replace(asset('storage') . '/', '', $image->image_path);
    Storage::disk('public')->delete($imagePath);
    $image->delete();

    return back()->with('success', 'Image deleted successfully.');
}

}
