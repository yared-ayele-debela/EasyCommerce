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

}
