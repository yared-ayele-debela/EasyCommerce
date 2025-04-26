<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HotelCategory;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index(){
        $categories=HotelCategory::latest()->paginate(10);
        return view('Hotel.frontend.pages.categories.index',compact('categories'));
    }

    public function show($id){
        try{
            $category=HotelCategory::findOrFail($id);
            $hotels = $category->hotels()->latest()->paginate(10); // paginate 10 hotels per page

            return view('Hotel.frontend.pages.categories.detail',compact('category','hotels'));
        }catch(Exception $e){
            return redirect()->back();
        }

    }

}
