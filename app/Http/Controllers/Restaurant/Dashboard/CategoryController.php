<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Restaurant;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
     public function __construct()
    {
        $this->middleware('admin.permission:view_restaurant_category')->only('index');
        $this->middleware('admin.permission:add_restaurant_category')->only('store');
        $this->middleware('admin.permission:edit_restaurant_category')->only(methods: 'update');
        $this->middleware('admin.permission:delete_restaurant_category')->only('destroy');
    }
    public function index()
    {
        $categories = Category::latest()->get();
        $restaurants = Restaurant::all();
        return view('Restaurant.dashboard.categories.index', compact('categories', 'restaurants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
            'discount' => 'required|numeric|min:0',
            'discount_type' => 'required|in:fixed,percentage',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $imagePath = asset('storage/' . $path); // Full URL like https://yourdomain.com/storage/categories/image.jpg
        }
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $imagePath,
            'is_active' => $request->is_active,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
        ]);

          
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add Restaurant Category', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'is_active' => 'required|boolean',
        'discount' => 'required|numeric|min:0',
        'discount_type' => 'required|in:fixed,percentage',
    ]);


    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($category->image) {
            // Convert URL to storage path
            $oldImagePath = str_replace(asset('storage') . '/', '', $category->image);
            Storage::disk('public')->delete($oldImagePath);
        }

        // Store new image and save full URL
        $path = $request->file('image')->store('categories', 'public');
        $category->image = asset('storage/' . $path);
    }
    $category->update([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
        'is_active' => $request->is_active,
        'discount' => $request->discount,
        'discount_type' => $request->discount_type,
    ]);

    $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update Restaurant Category', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

    return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
}

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();

        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Restaurant Category', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}