<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HotelPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelPhotoController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'photo_url' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo_url')) {
            // Store in "public/hotel_photos" directory
            $path = $request->file('photo_url')->store('hotel_photos', 'public');

            HotelPhoto::create([
                'hotel_id' => $request->hotel_id,
                'photo_url' => $path, // only path, not full URL
            ]);
        }
        return redirect()->back()->with('success', 'Photo uploaded successfully!');

    }

    public function destroy($id)
    {
        $photo = HotelPhoto::findOrFail($id);

        // Delete the image file from storage
        if (Storage::disk('public')->exists($photo->photo_url)) {
            Storage::disk('public')->delete($photo->photo_url);
        }

        // Delete from database
        $photo->delete();

        return redirect()->back()->with('success', 'Photo deleted successfully!');
    }
}
