<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Street;
use App\Models\SubCity;
use Illuminate\Http\Request;

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

        return redirect()->back()->with('success', 'Street added successfully.');
    }

    public function update(Request $request, Street $street)
    {
        $request->validate([
            'sub_city_id' => 'required|exists:sub_cities,id',
            'name' => 'required|string|max:255'
        ]);

        $street->update($request->all());

        return redirect()->back()->with('success', 'Street updated successfully.');
    }

    public function destroy(Street $street)
    {
        $street->delete();

        return redirect()->back()->with('success', 'Street deleted successfully.');
    }
}