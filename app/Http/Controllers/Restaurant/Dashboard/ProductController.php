<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\City;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\ProductImage;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantMenu;
use App\Models\Restaurant\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType==="Super Admin"){
            $products = Product::with('images','city','menu','category','subcategory')->latest()->get();
        }else{
            $restaurants=Restaurant::where('admin_id',Auth::guard('admin')->user()->id)->get();
            $restaurantId= $restaurants->pluck('id');
            $products = Product::with('images','city','menu','category','subcategory')->whereIn('restaurant_id',$restaurantId)->latest()->get();
        }

        // $products = Product::with('images','city','menu','category','subcategory')->get();
        // dd($products);
        $categories=Category::all();
        $subcategories=Subcategory::all();
        $menus=RestaurantMenu::all();
        $cities=City::all();
        return view('Restaurant.dashboard.products.index', compact('products','categories','menus','cities','subcategories'));
    }

    public function show($id){

        $restaurants=Restaurant::where('admin_id',Auth::guard('admin')->user()->id)->get();
        $restaurantId= $restaurants->pluck('id');

        $product = Product::with('images','sizes')->whereIn('restaurant_id',$restaurantId)->findOrFail($id);

        return view('Restaurant.dashboard.products.show',compact('product'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'subcategory_id'=>'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('product_images', 'public');
            $imagePath = asset('storage/' . $path); // Full URL: https://yourdomain.com/storage/product_images/filename.jpg
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'city_id' => $request->city_id,
            'menu_id' => $request->menu_id,
            'code' => $request->code,
            'price' => $request->price,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
            'image'=>$imagePath,
            'admin_id' => $request->admin_id,
            'most_populer' => $request->most_populer,
            'best_seller' => $request->best_seller,
            'is_free' => $request->is_free,
            'delivery_fee' => $request->delivery_fee,
            'delivery_time' => $request->delivery_time,
            'is_active' => $request->is_active,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => asset('storage/' . $path), // Store full URL
                ]);
            }
        }


        return back()->with('success', 'Product added successfully!');
    }

    public function update(Request $request, Product $product)
    {
        // dd($request->all());
        // $product->update($request->all());

        $product= Product::find($product->id);
        // dd($product);
        if ($request->hasFile('cover_image')) {
            // Delete old image if it exists
            if (!empty($product->cover_image)) {
                $oldPath = str_replace(asset('storage') . '/', '', $product->cover_image);
                Storage::disk('public')->delete($oldPath);
            }

            // Store and get new image URL
            $path = $request->file('cover_image')->store('product_images', 'public');
            $product->image = asset('storage/' . $path);
        }
        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'city_id' => $request->city_id,
            'menu_id' => $request->menu_id,
            'code' => $request->code,
            'price' => $request->price,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
            'admin_id' => $request->admin_id,
            'most_populer' => $request->most_populer,
            'best_seller' => $request->best_seller,
            'is_free' => $request->is_free,
            'delivery_fee' => $request->delivery_fee,
            'delivery_time' => $request->delivery_time,
            'is_active' => $request->is_active,
        ]);

         // Delete old images

         if ($request->hasFile('images')) {
            // Delete old images
            $oldImages = ProductImage::where('product_id', $product->id)->get();

            foreach ($oldImages as $image) {
                // If image_path is full URL, extract relative path
                $relativePath = str_replace(asset('storage') . '/', '', $image->image_path);
                Storage::disk('public')->delete($relativePath);

                $image->delete();
            }

            // Store new images
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('product_images', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => asset('storage/' . $path) // or just $path if you're storing relative
                ]);
            }
        }

        return back()->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
{
    $product = Product::findOrFail($id); // Better to use findOrFail

    // Delete multiple images
    $oldImages = ProductImage::where('product_id', $product->id)->get();
    foreach ($oldImages as $image) {
        $imagePath = str_replace(asset('storage') . '/', '', $image->image_path);
        Storage::disk('public')->delete($imagePath);
        $image->delete();
    }

    // Delete main product image
    if ($product->image) {
        $mainImagePath = str_replace(asset('storage') . '/', '', $product->image);
        Storage::disk('public')->delete($mainImagePath);
    }

    $product->delete();

    return response()->json(['success' => 'Product deleted successfully!']);
}

}
