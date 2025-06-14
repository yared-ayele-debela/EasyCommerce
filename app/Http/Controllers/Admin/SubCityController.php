<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\SubCity;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SubCityController extends Controller
{
    public function index()
    {
        $subCities = SubCity::with('city')->get();
        $cities = City::all(); // Fetch cities for dropdown
        return view('admin.sub_city.index', compact('subCities', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255'
        ]);

        SubCity::create($request->all());
       $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add sub city', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->back()->with('success', 'Sub City added successfully.');
    }

    public function update(Request $request, SubCity $subCity)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255'
        ]);

        $subCity->update($request->all());
   $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update sub city', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->back()->with('success', 'Sub City updated successfully.');
    }

    public function destroy(SubCity $subCity)
    {
        $subCity->delete();

        
         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete sub city', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->back()->with('success', 'Sub City deleted successfully.');
    }
}