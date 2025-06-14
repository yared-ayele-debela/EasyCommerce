<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\RestaurantMenu;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RestaurantMenuController extends Controller
{
    //
     public function __construct()
    {
        $this->middleware('admin.permission:view_restaurant_restaurant_menu')->only('index');
        $this->middleware('admin.permission:add_restaurant_restaurant_menu')->only('store');
        $this->middleware('admin.permission:edit_restaurant_restaurant_menu')->only(methods: 'update');
        $this->middleware('admin.permission:delete_restaurant_restaurant_menu')->only('destroy');
    }
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

          $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add Restaurant Menu', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


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
           $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update Restaurant Menu', description: Auth::guard('admin')->user()->name . " at {$formattedDateTime}");



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

           $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Restaurant Menu', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        return redirect()->route('menus.index')->with('success', 'Restaurant Menu deleted successfully.');
    }
}