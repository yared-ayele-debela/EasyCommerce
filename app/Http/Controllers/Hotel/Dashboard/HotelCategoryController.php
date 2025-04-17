<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HotelCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelCategoryController extends Controller
{
    //
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

        $path = $request->file('image')->store('hotel_categories', 'public');

        HotelCategory::create([
            'name' => $request->name,
            'image' => $path,
        ]);

        return redirect()->back()->with('success', 'Hotel category added!');
    }

    public function update(Request $request, $id)
    {
        $category = HotelCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hotel_categories', 'public');
            $category->image = $path;
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->back()->with('success', 'Hotel category updated!');
    }

    public function destroy($id)
    {
        $category = HotelCategory::findOrFail($id);
            // Delete the image file if it exists
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->back()->with('success', 'Hotel category deleted!');
    }
}