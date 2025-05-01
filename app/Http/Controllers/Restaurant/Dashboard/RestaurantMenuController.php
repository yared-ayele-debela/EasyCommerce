<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\RestaurantMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RestaurantMenuController extends Controller
{
    //
    public function index()
    {
        $restaurant_menus = RestaurantMenu::all();
        return view('Restaurant.dashboard.menus.index', compact('restaurant_menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('menus', 'public') : null;
        $imageUrl = $imagePath ? asset('storage/' . $imagePath) : null;

        RestaurantMenu::create([
            'name'      => $request->name,
            'slug'      => Str::slug($request->name),
            'image'     => $imageUrl,
            'is_active' => $request->is_active,
        ]);


        return redirect()->route('menus.index')->with('success', 'Restaurant Menu created successfully.');
    }

    public function update(Request $request,  $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
        ]);
        // dd($request->all());

        $RestaurantMenu = RestaurantMenu::findOrFail($id);

        DB::transaction(function () use ($request, $RestaurantMenu) {
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($RestaurantMenu->image) {
                    // Convert full URL to path for deletion if needed
                    $oldImagePath = str_replace(asset('storage') . '/', '', $RestaurantMenu->image);
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                }

                // Store the new image and generate full URL
                $path = $request->file('image')->store('menus', 'public');
                $RestaurantMenu->image = asset('storage/' . $path);
            }

            $RestaurantMenu->update([
                'name'      => $request->name,
                'slug'      => Str::slug($request->name),
                'is_active' => $request->is_active,
                'image'     => $RestaurantMenu->image,
            ]);
        });

        return redirect()->route('menus.index')->with('success', 'Restaur updated successfully.');
    }

    public function destroy($id)
    {
        $RestaurantMenu = RestaurantMenu::findOrFail($id);
        // Delete the image if it exists and is stored in public disk
        if ($RestaurantMenu->image) {
            // Extract the relative path from the full URL if necessary
            $imagePath = str_replace(asset('storage') . '/', '', $RestaurantMenu->image);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }
        $RestaurantMenu->delete();
        return redirect()->route('menus.index')->with('success', 'Restaurant Menu deleted successfully.');
    }
}
