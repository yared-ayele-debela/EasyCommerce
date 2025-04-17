<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HotelSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderBannerController extends Controller
{
    //
    public function index()
    {
        $banners = HotelSlider::latest()->get();
        return view('Hotel.dashboard.slider-banners.index', compact('banners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'link'        => 'nullable',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif',
            'is_active'   => 'nullable|boolean'
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        HotelSlider::create([
            'title'       => $request->title,
            'description' => $request->description,
            'link'        => $request->link,
            'image'       => $imagePath,
            'is_active'   => $request->is_active
        ]);

        return redirect()->route('hotel-slider-banners.index')->with('success', 'Banner added successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'title'       => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'link'        => 'nullable|url',
        //     'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'is_active'   => 'required'
        // ]);

        $slider=HotelSlider::findOrFail($id);
        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($slider->image);
            // Store new image
            $imagePath = $request->file('image')->store('banners', 'public');
            $slider->image = $imagePath;
        }

        $slider->update([
            'title'       => $request->title,
            'description' => $request->description,
            'link'        => $request->link,
            'is_active'   => $request->is_active
        ]);

        return redirect()->route('hotel-slider-banners.index')->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sliderBanner=HotelSlider::findOrFail($id);

        Storage::disk('public')->delete($sliderBanner->image);
        $sliderBanner->delete();
        return response()->json(['success' => 'Banner deleted successfully!']);
    }
}
