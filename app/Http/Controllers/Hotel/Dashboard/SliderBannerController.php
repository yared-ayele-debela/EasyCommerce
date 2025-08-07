<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HotelSlider;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SliderBannerController extends Controller
{
    //
      public function __construct()
    {
        $this->middleware('admin.permission:view_hotel_slider')->only('index');
        $this->middleware('admin.permission:add_hotel_slider')->only('store');
        $this->middleware('admin.permission:edit_hotel_slider')->only(methods: 'update');
        $this->middleware('admin.permission:delete_hotel_slider')->only('destroy');
    }
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

        $imagePath = $request->file('image')->store('banners', 'public'); // e.g. banners/image_123.jpg

        HotelSlider::create([
            'title'       => $request->title,
            'description' => $request->description,
            'link'        => $request->link,
            'image'       => $imagePath, // ✅ just the relative path
            'is_active'   => $request->is_active
        ]);


        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Add Hotel Slider Banner', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

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

        $slider = HotelSlider::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }

            // Store new image and save relative path only
            $newImagePath = $request->file('image')->store('banners', 'public');
            $slider->image = $newImagePath;
        }

        // Update the rest of the fields
        $slider->update([
            'title'       => $request->title,
            'description' => $request->description,
            'link'        => $request->link,
            'is_active'   => $request->is_active,
            'image'       => $slider->image, // ensure image is included in update
        ]);

          $currentDateTime = Carbon::now();
          $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
          ActivityLogger::log('Update Hotel Slider Banner', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        return redirect()->route('hotel-slider-banners.index')->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $sliderBanner = HotelSlider::findOrFail($id);

    // Safely extract relative path if image is stored as full URL
    if ($sliderBanner->image) {
                Storage::disk('public')->delete($sliderBanner->image);
            }
    $sliderBanner->delete();
         $currentDateTime = Carbon::now();
          $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
          ActivityLogger::log('Delete Hotel Slider Banner', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

    return response()->json(['success' => 'Banner deleted successfully!']);
}

}
