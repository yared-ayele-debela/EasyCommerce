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
use App\Models\Roles;
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

        $role=Roles::where('name',$adminType)->first();


        if($role->group==="general"){
             $restaurants=Restaurant::latest()->get();
            $products = Product::with('images','city','menu','category','subcategory')->latest()->paginate(10);
        }else{
            $restaurants=Restaurant::where('admin_id',Auth::guard('admin')->user()->id)->get();
            $restaurantId= $restaurants->pluck('id');
            $products = Product::with('images','city','menu','category','subcategory')->whereIn('restaurant_id',$restaurantId)->latest()->paginate(10);
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
            'restaurant_id'=>'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('product_images', 'public');
            $imagePath = $path; // Just 'product_images/filename.jpg'
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
            'weight' => $request->weight,
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
                $path = $image->store('product_images', 'public'); // e.g., 'product_images/filename.jpg'

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path, // Store only the relative path
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
    // Find the product (you already have $product injected, no need to refind)
    // $product = Product::find($product->id); // not needed, you already have $product

    // Handle cover image update
    if ($request->hasFile('cover_image')) {
        // Delete old image if exists (image path stored as relative path)
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Store new image and save relative path (without full URL)
        $path = $request->file('cover_image')->store('product_images', 'public');
        $product->image = $path;
    }

    // Update other fields including new image path (if any)
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
        'product_tax' => $request->product_tax,
        'discount_type' => $request->discount_type,
        'discount' => $request->discount,
                    'weight' => $request->weight,
        'admin_id' => $request->admin_id,
        'most_populer' => $request->most_populer,
        'best_seller' => $request->best_seller,
        'is_free' => $request->is_free,
        'delivery_fee' => $request->delivery_fee,
        'delivery_time' => $request->delivery_time,
        'is_active' => $request->is_active,
        'image' => $product->image, // set image relative path here
    ]);

    // Delete old images if new images uploaded
    if ($request->hasFile('images')) {
        $oldImages = ProductImage::where('product_id', $product->id)->get();
        foreach ($oldImages as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        // Store new images with relative path
        foreach ($request->file('images') as $imageFile) {
            $path = $imageFile->store('product_images', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path, // store relative path, not full URL
            ]);
        }
    }

    // Logging activity
    $currentDateTime = Carbon::now();
    $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
    ActivityLogger::log('Update Restaurant Product', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

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
    $mainImagePath = str_replace(url('storage') . '/', '', $product->image);

    if (Storage::disk('public')->exists($mainImagePath)) {
        Storage::disk('public')->delete($mainImagePath);
    }
}


    $product->delete();
     $currentDateTime = Carbon::now();
    $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
    ActivityLogger::log( 'Delete Restaurant Product', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


    return response()->json(['success' => 'Product deleted successfully!']);
}

}
