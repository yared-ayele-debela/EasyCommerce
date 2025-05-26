<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

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


    public function bybrands($id){
        try{
            $id=decrypt($id);
            $brand=Brand::where('id',$id)->first();
            if(!$brand){
                Alert::toast("something is wrong!!",'error');
                return redirect()->back();
            }
            $cms_pages = CmsPage::get()->toArray();
            $appsettings = AppSetting::all()->toArray();
            
            $products=Product::where('brand_id',$id)->simplePaginate(20);

        return view('Ecommerce.brands.index',compact('products','brand','cms_pages','appsettings'));

        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }


    }

}