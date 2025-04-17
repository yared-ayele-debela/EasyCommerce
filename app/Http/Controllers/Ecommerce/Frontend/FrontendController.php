<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Advertisement;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\FlashDealProduct;
use App\Models\Group;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Rating;
use App\Models\Vendor;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //
    public function index()
    {
        $allvendor = Vendor::with(['vendorbusinessdetails', 'adminvendor'])
        ->withCount('products')
        ->where('status', 1)
        ->inRandomOrder()
        ->get();

        $vendorRatingsCount = Rating::with('product')
            ->get()
            ->groupBy(fn($rating) => $rating->product->vendor_id ?? null)
            ->map(fn($ratings) => $ratings->count());

        $group = Group::with('categories')->get();
        $alladvertisement = Advertisement::where('is_approved', 1)->get();
        $new_products = Product::where('status', 1)->orderByDesc('id')->get();

        $getCategory = Category::where('parent_id', 0)->where('status', 1)->get();
        $isfeatured = Product::where('is_Featured', 'Yes')->where('status', 1)->inRandomOrder()->get();
        $discountedproduct = Product::where('product_discount', '>', 0)->where('status', 1)->inRandomOrder()->get();

        $banners = Banner::where('type', 'Slider')->where('status', 1)->get();
        $fixbanners = Banner::where('type', 'Fix')->where('status', 1)->get();

        $all_products=Product::where('status', 1)->orderByDesc('id')->get();

        $getVendorShop = Admin::with('vendorBusiness')->where('type', 'vendor')->get();

        $new_arrival=Product::latest()->limit(4)->get();
        $now = \Carbon\Carbon::now('UTC');
        $featured_flash_deal = FlashDeal::where('status', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->first();

        $flash_deal_products = collect();
        if ($featured_flash_deal) {
            $flash_deal_ids = $featured_flash_deal->pluck('id');
            $flash_deal_products = FlashDealProduct::with('product')
                ->whereIn('flash_deal_id', $flash_deal_ids)
                ->inRandomOrder()
                ->get();
        }
        $allbrands = Brand::all()->where('status', 1)->toArray();


        return view('all_frontend_layouts.ecommerce', compact('allbrands','new_arrival','alladvertisement', 'getCategory', 'isfeatured', 'discountedproduct', 'banners', 'fixbanners', 'group', 'new_products', 'all_products', 'getVendorShop', 'allvendor', 'vendorRatingsCount', 'featured_flash_deal', 'flash_deal_products'));
    }
}
