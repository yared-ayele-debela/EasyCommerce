<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoriesController extends Controller
{
    //
    public function index(){
        $cms_pages = CmsPage::get()->toArray();
        $appsettings = AppSetting::all()->toArray();
        $categories = Category::where('status',1)->simplePaginate(20);

        return view('NewFrontEndPage.lists.vendors.categories.allcategories',compact('categories','appsettings','cms_pages'));
    }
    public function bybrands($id){
        try{
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