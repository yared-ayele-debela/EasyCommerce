<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\SubCity;
use Illuminate\Http\Request;

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

        return redirect()->back()->with('success', 'Sub City added successfully.');
    }

    public function update(Request $request, SubCity $subCity)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255'
        ]);

        $subCity->update($request->all());

        return redirect()->back()->with('success', 'Sub City updated successfully.');
    }

    public function destroy(SubCity $subCity)
    {
        $subCity->delete();

        return redirect()->back()->with('success', 'Sub City deleted successfully.');
    }
}