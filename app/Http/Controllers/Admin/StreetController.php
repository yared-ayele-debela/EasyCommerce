<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Street;
use App\Models\SubCity;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class StreetController extends Controller
{
    public function index()
    {
        $streets = Street::with('subCity')->get();
        $subCities = SubCity::all();
        return view('admin.streets.index', compact('streets', 'subCities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_city_id' => 'required|exists:sub_cities,id',
            'name' => 'required|string|max:255'
        ]);

        Street::create($request->all());

        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add Street', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->back()->with('success', 'Street added successfully.');
    }

    public function update(Request $request, Street $street)
    {
        $request->validate([
            'sub_city_id' => 'required|exists:sub_cities,id',
            'name' => 'required|string|max:255'
        ]);

        $street->update($request->all());
  $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update Street', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->back()->with('success', 'Street updated successfully.');
    }

    public function destroy(Street $street)
    {
        $street->delete();
       $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Street', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->back()->with('success', 'Street deleted successfully.');
    }
}
