<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        // dd("hello");
        $subcategories = Subcategory::with('category')->latest()->get();
        $categories = Category::all();
        return view('Restaurant.dashboard.subcategories.index', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:restaurant_categories,id',
        ]);

        $subcategory = Subcategory::create($request->all());

        return redirect()->back()->with(['success' => 'Subcategory added successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:restaurant_categories,id',
        ]);

        $subcategory = Subcategory::findOrFail($id);
        $subcategory->update($request->all());

        return redirect()->back()->with(['success' => 'Subcategory updated successfully']);
    }

    public function destroy($id)
    {
        Subcategory::findOrFail($id)->delete();

        return redirect()->back()->with(['success' => 'Subcategory deleted successfully']);
    }
}