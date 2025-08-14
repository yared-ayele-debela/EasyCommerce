<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HotelCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    //
    public function index(){

        $categories = Cache::remember('hotel_categories_page_' . request('page', 1), 3600, function () {
        return HotelCategory::latest()->paginate(10);
    });

        return view('Hotel.frontend.pages.categories.index',compact('categories'));
    }

    public function show($id){
        try{
             $category = Cache::remember("hotel_category_{$id}", 3600, function () use ($id) {
            return HotelCategory::findOrFail($id);
        });

        // Cache hotels for this category and page
        $hotels = Cache::tags(['hotels'])->remember("hotels_in_category_{$id}_page_" . request('page', 1), 3600, function () use ($category) {
            return $category->hotels()->latest()->paginate(10);
        });
            return view('Hotel.frontend.pages.categories.detail',compact('category','hotels'));
        }catch(Exception $e){
            return redirect()->back();
        }

    }

}
