<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Amenity;
use App\Services\ActivityLogger;
use App\Services\PermissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AmenityController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin.permission:view_hotel_amenity')->only('index');
        $this->middleware('admin.permission:add_hotel_amenity')->only('store');
        $this->middleware('admin.permission:edit_hotel_amenity')->only(methods: 'update');
        $this->middleware('admin.permission:delete_hotel_amenity')->only('destroy');
    }
    public function index()
    {
        $amenities = Amenity::latest()->paginate(10);
        return view('Hotel.dashboard.amenities.index', compact('amenities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $iconPath = null;

        if ($request->hasFile('icon')) {
            $storedPath = $request->file('icon')->store('icons', 'public');
            $iconPath = asset('storage/' . $storedPath); // Convert to full URL
        }

        Amenity::create([
            'name' => $request->name,
            'icon' => $iconPath,
        ]);
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Add Amenity', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");



        return redirect()->back()->with('success', 'Amenity created successfully.');
    }

    public function update(Request $request, $id)
    {
        $amenity = Amenity::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            // Delete old icon if it exists (even if stored as full URL)
            if ($amenity->icon) {
                $oldIconPath = str_replace(asset('storage') . '/', '', $amenity->icon);
                Storage::disk('public')->delete($oldIconPath);
            }

            // Store new icon and save full URL
            $storedPath = $request->file('icon')->store('icons', 'public');
            $amenity->icon = asset('storage/' . $storedPath);
        }

        $amenity->name = $request->name;
        $amenity->save();

          $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Update Amenity', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");



        return redirect()->back()->with('success', 'Amenity updated successfully.');
    }

    public function destroy($id)
    {
        $amenity = Amenity::findOrFail($id);

        if ($amenity->icon) {
            $iconPath = str_replace(asset('storage') . '/', '', $amenity->icon);
            Storage::disk('public')->delete($iconPath);
        }

        $amenity->delete();

        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Delete Amenity', description: Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        return redirect()->back()->with('success', 'Amenity deleted.');
    }
}