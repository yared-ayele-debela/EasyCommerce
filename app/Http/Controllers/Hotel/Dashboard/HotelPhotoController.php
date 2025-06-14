<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HotelPhoto;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HotelPhotoController extends Controller
{

      public function __construct()
    {
        $this->middleware('admin.permission:add_hotel_hotel_photo')->only('store');
        $this->middleware('admin.permission:delete_hotel_hotel_photo')->only('destroy');
    }
    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'photo_url' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo_url')) {
            $path = $request->file('photo_url')->store('hotel_photos', 'public');

            $fullUrl = asset('storage/' . $path); // generate full URL

            HotelPhoto::create([
                'hotel_id' => $request->hotel_id,
                'photo_url' => $fullUrl, // store full URL
            ]);
        }

          $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Add Hotel Photos', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        

        return redirect()->back()->with('success', 'Photo uploaded successfully!');
    }

    public function destroy($id)
    {
        $photo = HotelPhoto::findOrFail($id);
        // Extract the relative path from the full URL
        $relativePath = str_replace(asset('storage') . '/', '', $photo->photo_url);

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        $photo->delete();

    $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Delete Hotel Photos', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->back()->with('success', 'Photo deleted successfully!');
    }
}