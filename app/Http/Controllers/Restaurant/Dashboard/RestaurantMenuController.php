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
        return view('restaurant.dashboard.menus.index', compact( 'restaurant_menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('menus', 'public') : null;
        RestaurantMenu::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
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

 $RestaurantMenu= RestaurantMenu::find($id);
//  dd($RestaurantMenu);
    DB::transaction(function () use ($request, $RestaurantMenu) {
        if ($request->hasFile('image')) {
            if ($RestaurantMenu->image) {
                Storage::disk('public')->delete($RestaurantMenu->image);
            }
            $RestaurantMenu->image = $request->file('image')->store('menus', 'public');
        }
        $RestaurantMenu->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => $request->is_active,
            'image' => $RestaurantMenu->image ?? $RestaurantMenu->image, // Ensure image update
        ]);
    });

    return redirect()->route('menus.index')->with('success', 'Restaur updated successfully.');
}

    public function destroy($id)
    {
        $RestaurantMenu = RestaurantMenu::find($id);
        $RestaurantMenu->delete();
        return redirect()->route('menus.index')->with('success', 'Restaurant Menu deleted successfully.');
    }
}