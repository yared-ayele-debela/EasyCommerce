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
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%")
                            ->take(5)
                            ->get();

        return response()->json($products);
    }


    public function filter(Request $request)
    {
        try{

        $filter = $request->input('type');

        switch ($filter) {
            case 'specail_offer':
                $products = Product::where('discount', '>', 0)->latest()->get();
                break;
            case 'most_popular':
                $products = Product::where('most_populer', 1)->latest()->get();
                break;
            case 'best_seller':
                $products = Product::where('best_seller', 1)->latest()->get();
                break;
            case 'all':
                $products = Product::where('is_active', 1)->latest()->get();
                break;
            default:
                $products = Product::all();
                break;
        }
    }
    catch(Exception $e){
        return redirect()->back();
    }
  

    return view('restaurant.frontend.pages.products.filtered_products', compact('products', 'filter'));
    }

    public function index(Request $request){
        $products = Product::where('is_active',1)->latest()->get();
        // dd($products);
        
        $categories = Category::all();
        $restaurants = Restaurant::all();
        $subcategories= Subcategory::all();
        $cities=ModelsCity::all();
        $menus=RestaurantMenu::all();
        
        return view('Restaurant.frontend.pages.products.index',compact('products','categories', 'restaurants','cities','subcategories','menus'));
    }

    public function filterProducts(Request $request)
{
    $query = Product::query();

    if ($request->search) {
        $query->where('name', 'LIKE', "%{$request->search}%")
              ->orWhere('code', 'LIKE', "%{$request->search}%")
              ->orWhere('description', 'LIKE', "%{$request->search}%");
    }

    if ($request->restaurant_id) $query->where('restaurant_id', $request->restaurant_id);
    if ($request->delivery_fee) $query->where('delivery_fee','<=', $request->delivery_fee);
    if ($request->delivery_time) $query->where('delivery_time','<=', $request->delivery_time);
    if ($request->category_id) $query->where('category_id', $request->category_id);
    if ($request->subcategory_id) $query->where('subcategory_id', $request->subcategory_id);
    if ($request->city_id) $query->where('city_id', $request->city_id);
    if ($request->is_free) $query->where('is_free', $request->is_free);
    if ($request->discount_type) $query->where('discount_type', $request->discount_type);
    if ($request->most_popular) $query->where('most_populer', 1);
    if ($request->best_seller) $query->where('best_seller', 1);
    if ($request->discounted) $query->where('discount','>', 0);

    $products = $query->latest()->get();

    return view('Restaurant.frontend.pages.products.partail', compact('products'))->render();
}



    public function detail($id){
        $product=Product::with(['images','sizes','ratings'])->findOrFail($id);
        $related_products=Product::where('category_id',$product->category_id)->where('id','!=',$product->id)->get();

        return view('Restaurant.frontend.pages.products.detail',compact('product','related_products'));
    }
}