<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //
    public function index() {
        $categories = Category::where('parent_id', 0)->where('status', 1)->latest()->get();

        return view('Ecommerce.categories.index', compact('categories'));
    }
    public function show($id)
    {
        $ids=decrypt($id);
        $category = Category::where('id',$ids)->first();
        $products = $category->products()->withAvg('ratings', 'rating')->where('status', 1)->paginate(12);

        return view('Ecommerce.categories.show', compact('category', 'products'));
    }


}
