<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City as ModelsCity;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\City;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantMenu;
use App\Models\Restaurant\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function index(Request $request){
        // Fetch products with filters
        $query = Product::query();

        // Apply filters dynamically
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }
    
        if ($request->has('restaurant_id')) {
            $query->where('restaurant_id', $request->restaurant_id);
        }
    
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        if ($request->has('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }
    
        if ($request->has('city_id')) {
            $query->where('city_id', $request->city_id);
        }
    
        if ($request->has('menu_id')) {
            $query->where('menu_id', $request->menu_id);
        }
    
        // if ($request->has('price')) {
        //     $query->where('price', '<=', $request->price);
        // }
    
        if ($request->has('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }
    
        if ($request->has('most_populer')) {
            $query->where('most_populer', true);
        }
    
        if ($request->has('best_seller')) {
            $query->where('best_seller', true);
        }
    
        if ($request->has('is_free')) {
            $query->where('is_free', $request->is_free);
        }
    
        // if ($request->has('delivery_fee')) {
        //     $query->where('delivery_fee', '<=', $request->delivery_fee);
        // }
    
        // if ($request->has('delivery_time')) {
        //     $query->where('delivery_time', '<=', $request->delivery_time);
        // }
    
        $products = $query->paginate(12);
    
        if ($request->ajax()) {
            return response()->json([
                'products' => view('Restaurant.frontend.pages.products.partail', compact('products'))->render()
            ]);
        }

    $categories = Category::all();
    $restaurants = Restaurant::all();
    $subcategories= Subcategory::all();
    $cities=ModelsCity::all();
    $menus=RestaurantMenu::all();
    

        return view('Restaurant.frontend.pages.products.index',compact('products','categories', 'restaurants','cities','subcategories','menus'));
    }

    public function detail($id){
        $product=Product::with(['images','sizes'])->findOrFail($id);
        $related_products=Product::where('category_id',$product->category_id)->where('id','!=',$product->id)->get();

        return view('Restaurant.frontend.pages.products.detail',compact('product','related_products'));
    }
}