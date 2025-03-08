<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\SliderBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderBannerController extends Controller
{
    //
    public function index()
    {
        $banners = SliderBanner::latest()->get();
        return view('restaurant.dashboard.slider-banners.index', compact('banners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'link'        => 'nullable|url',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'   => 'required|boolean'
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        SliderBanner::create([
            'title'       => $request->title,
            'description' => $request->description,
            'link'        => $request->link,
            'image'       => $imagePath,
            'is_active'   => $request->is_active
        ]);

        return redirect()->route('slider-banners.index')->with('success', 'Banner added successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SliderBanner $sliderBanner)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'link'        => 'nullable|url',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'   => 'required|boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($sliderBanner->image);
            // Store new image
            $imagePath = $request->file('image')->store('banners', 'public');
            $sliderBanner->image = $imagePath;
        }

        $sliderBanner->update([
            'title'       => $request->title,
            'description' => $request->description,
            'link'        => $request->link,
            'is_active'   => $request->is_active
        ]);

        return redirect()->route('slider-banners.index')->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SliderBanner $sliderBanner)
    {
        // Delete the image
        Storage::disk('public')->delete($sliderBanner->image);
        $sliderBanner->delete();
        return response()->json(['success' => 'Banner deleted successfully!']);
    }
}