<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\City;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\ProductImage;
use App\Models\Restaurant\RestaurantMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images','city','menu','category')->get();
        $categories=Category::all();
        $menus=RestaurantMenu::all();
        $cities=City::all();
        return view('restaurant.dashboard.products.index', compact('products','categories','menus','cities'));
    }

    public function show($id){

        $product = Product::with('images','sizes')->find($id);
        return view('Restaurant.dashboard.products.show',compact('product'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $request->file('cover_image') ? $request->file('cover_image')->store('product_images', 'public') : null;

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category_id' => $request->category_id,
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
            'is_active' => $request->is_active,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return back()->with('success', 'Product added successfully!');
    }

    public function update(Request $request, Product $product)
    {
        // $product->update($request->all());

        if ($request->hasFile('cover_image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('cover_image')->store('product_images', 'public');
            $product->save();
        }
        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'city_id' => $request->city_id,
            'menu_id' => $request->menu_id,
            'code' => $request->code,
            'price' => $request->price,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
            'admin_id' => $request->admin_id,
            'most_populer' => $request->most_populer,
            'best_seller' => $request->best_seller,
            'is_active' => $request->is_active,
        ]);

         // Delete old images

        if ($request->hasFile('images')) {
            $oldImages = ProductImage::where('product_id', $product->id)->get();
            foreach ($oldImages as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return back()->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product=Product::find($id);
        $oldImages = ProductImage::where('product_id', $product->id)->get();
        foreach ($oldImages as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return response()->json(['success' => 'Product deleted successfully!']);
    }
}