<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Restaurant;
use Illuminate\Http\Request;
use PDO;

class CategoryController extends Controller
{
    //

    public function index(){
        $categories=Category::where('is_active',1)->latest()->paginate(10);
        return view('Restaurant.frontend.pages.categories.index',compact('categories'));
    }

    public function detail($id){
        $category = Category::with(['products','subcategories'])->where('id',$id)->first();

         // Fetch restaurants that have products in this category
        $restaurants = Restaurant::whereHas('products', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->get();
        return view('Restaurant.frontend.pages.categories.detail',compact('category','restaurants'));
    }
}
