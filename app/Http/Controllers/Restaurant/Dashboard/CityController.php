<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('restaurant.dashboard.cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:restaurant_cities,name|max:255',
        ]);

        City::create(['name' => $request->name]);

        return response()->json(['success' => 'City added successfully.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:restaurant_cities,name,' . $id,
        ]);

        $city = City::findOrFail($id);
        $city->update(['name' => $request->name]);

        return response()->json(['success' => 'City updated successfully.']);
    }

    public function destroy($id)
    {
        City::findOrFail($id)->delete();

        return response()->json(['success' => 'City deleted successfully.']);
    }
}