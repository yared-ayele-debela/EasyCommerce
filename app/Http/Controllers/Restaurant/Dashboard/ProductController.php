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
use App\Models\Tax;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
     public function __construct()
    {
        $this->middleware('admin.permission:view_restaurant_product')->only('index','show');
        $this->middleware('admin.permission:add_restaurant_product')->only('store');
        $this->middleware('admin.permission:edit_restaurant_product')->only(methods: 'update');
        $this->middleware('admin.permission:delete_restaurant_product')->only('destroy');
    }

    public function index()
    {
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType==="Super Admin"){
             $restaurants=Restaurant::latest()->get();

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
        $taxs=Tax::all();

        return view('Restaurant.dashboard.products.index', compact('taxs','products','categories','menus','cities','subcategories','restaurants'));
    }

    public function show($id){

        $restaurants=Restaurant::where('admin_id',Auth::guard('admin')->user()->id)->get();
        $restaurantId= $restaurants->pluck('id');

        $product = Product::with('images','sizes')->whereIn('restaurant_id',$restaurantId)->findOrFail($id);

        // dd($product);
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
        // dd($request->all());
        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'restaurant_id' => $request->restaurant_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'city_id' => $request->city_id,
            'menu_id' => $request->menu_id,
            'code' => $request->code,
            'price' => $request->price,
            'product_tax' =>$request->product_tax,
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


        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add Restaurant Product', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

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
             'restaurant_id' => $request->restaurant_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'city_id' => $request->city_id,
            'menu_id' => $request->menu_id,
            'code' => $request->code,
            'price' => $request->price,
            'product_tax' =>$request->product_tax,
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

         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update Restaurant Product', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


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
     $currentDateTime = Carbon::now();
    $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
    ActivityLogger::log( 'Delete Restaurant Product', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


    return response()->json(['success' => 'Product deleted successfully!']);
}

}
