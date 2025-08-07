<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\SliderBanner;
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
        $this->middleware('admin.permission:view_restaurant_banners')->only('index');
        $this->middleware('admin.permission:add_restaurant_banners')->only('store');
        $this->middleware('admin.permission:edit_restaurant_banners')->only(methods: 'update');
        $this->middleware('admin.permission:delete_restaurant_banners')->only('destroy');
    }
    public function index()
    {
        $banners = SliderBanner::latest()->get();
        return view('Restaurant.dashboard.slider-banners.index', compact('banners'));
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

        $imagePath = null;

        if ($request->hasFile('image')) {
            // Store and get only the relative path like 'banners/filename.jpg'
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        SliderBanner::create([
            'title'       => $request->title,
            'description' => $request->description,
            'link'        => $request->link,
            'image'       => $imagePath, // Store relative path only
            'is_active'   => $request->is_active
        ]);
        // Convert to full URL for display

          $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add Restaurant Slider', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

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
    // Delete old image if it exists
    if ($sliderBanner->image) {
        $oldPath = $sliderBanner->image; // This should be something like 'banners/oldfile.jpg'
        Storage::disk('public')->delete($oldPath);
    }

    // Store new image and keep only relative path
    $storedPath = $request->file('image')->store('banners', 'public');
    $sliderBanner->image = $storedPath;
}


        $sliderBanner->update([
            'title'       => $request->title,
            'description' => $request->description,
            'link'        => $request->link,
            'is_active'   => $request->is_active
        ]);

          $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log(  'Update Restaurant Slider', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        return redirect()->route('slider-banners.index')->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SliderBanner $sliderBanner)
    {
        // Delete the image
       
        if ($sliderBanner->image) {
                $oldPath = $sliderBanner->image; // This should be something like 'banners/oldfile.jpg'
                Storage::disk('public')->delete($oldPath);
            }

        $sliderBanner->delete();

          $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Restaurant Slider', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return response()->json(['success' => 'Banner deleted successfully!']);
    }
}