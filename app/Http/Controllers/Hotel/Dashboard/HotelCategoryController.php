<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HotelCategory;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HotelCategoryController extends Controller
{
    //
      public function __construct()
    {
        $this->middleware('admin.permission:view_hotel_hotel_category')->only('index');
        $this->middleware('admin.permission:add_hotel_hotel_category')->only('store');
        $this->middleware('admin.permission:edit_hotel_hotel_category')->only(methods: 'update');
        $this->middleware('admin.permission:delete_hotel_hotel_category')->only('destroy');
    }

    public function index()
    {
        $categories = HotelCategory::latest()->paginate(8);
        return view('Hotel.dashboard.hotel_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048'
        ]);

        $storedPath = $request->file('image')->store('hotel_categories', 'public');
        HotelCategory::create([
            'name'  => $request->name,
            'image' => $storedPath, // store only the path, not full URL
        ]);
        // Log the activity


        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Add Hotel Category', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        return redirect()->back()->with('success', 'Hotel category added!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048'
        ]);

        $category = HotelCategory::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image); // Use stored relative path directly
            }

            // Store new image without full URL
            $path = $request->file('image')->store('hotel_categories', 'public');
            $category->image = $path; // Store only the relative path
        }

        // Update name
        $category->name = $request->name;
        $category->save();


         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Update Hotel Category', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        return redirect()->back()->with('success', 'Hotel category updated!');
    }


    public function destroy($id)
    {
        $category = HotelCategory::findOrFail($id);
        if ($category->image) {
                Storage::disk('public')->delete($category->image); // Use stored relative path directly
        }
        $category->delete();


         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Hotel Category', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        return redirect()->back()->with('success', 'Hotel category deleted!');
    }
}
