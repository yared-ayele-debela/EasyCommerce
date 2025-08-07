<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\FlashDealProduct;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Rating;
use App\Notifications\ProductInterestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{

    public function detail($Id)
{
    // Decrypt the product ID
    $id = decrypt($Id);

    $product = Product::with([
        'group',
        'category',
        'brand',
        'images',
        'vendor',
        'attributes' => function ($query) {
            $query->where('stock', '>', 0)->where('status', 1);
        },
    ])->findOrFail($id);

    $productId = $product->id;

    // Use caching for category details to avoid re-fetching on every request
    $categoryDetails = Cache::remember("category_details_{$product->category->id}", 60, function () use ($product) {
        return Category::categoryDetails($product->category->url);
    });

    // Total available stock (optimized with aggregation)
    $totalStock = $product->quantity;

    // Similar products (optimized by reducing number of queries)
    $similarProducts = Product::with(['attributes', 'brand', 'ratings'])
        ->where('category_id', $product->category_id)
        ->where('id', '!=', $productId)
        ->inRandomOrder()
        ->limit(6)
        ->get();

    // Manage session for recently viewed products
    $sessionId = Session::get('session_id') ?? md5(uniqid(rand(), true));
    Session::put('session_id', $sessionId);

    // Track recently viewed product (optimized with upsert)
    DB::table('recently_viewed_products')->updateOrInsert(
        ['product_id' => $productId, 'session_id' => $sessionId],
        ['session_id' => $sessionId]
    );

    // Fetch recently viewed products (optimized)
    $recentProductIds = DB::table('recently_viewed_products')
        ->where('session_id', $sessionId)
        ->where('product_id', '!=', $productId)
        ->inRandomOrder()
        ->limit(4)
        ->pluck('product_id');

    $recentlyViewedProducts = Product::with('brand', 'attributes', 'ratings')
        ->whereIn('id', $recentProductIds)
        ->get();

    // Group products by color (optimized query)
    $groupProducts = [];
    if (!empty($product->product_color)) {
        $groupProducts = Product::with('attributes')
            ->select('id', 'product_image')
            ->where('product_color', $product->product_color)
            ->where('id', '!=', $productId)
            ->where('status', 1)
            ->get();
    }

    // Ratings and average (optimized with aggregation)
    $ratings = Rating::where('product_id', $productId)
        ->where('status', 1)
        ->orderByDesc('id')
        ->get();

    $ratingsCount = $ratings->count();
    $ratingsSum = $ratings->sum('rating');
    $avgRating = $ratingsCount > 0 ? round($ratingsSum / $ratingsCount, 2) : 0;
    $avgStarRating = $ratingsCount > 0 ? round($ratingsSum / $ratingsCount) : 0;

    $check_ordered_by_current_user = 0;
    if (auth()->check()) {
        $check_ordered_by_current_user = OrderProduct::where('user_id', auth()->user()->id)
            ->where('product_id', $productId)
            ->exists();
        $check_ordered_by_current_user = $check_ordered_by_current_user ? 1 : 0;
    }
    // dd($check_ordered_by_current_user);
    // Return view with all the data
    return view('Ecommerce.products.product-detail', compact(
        'product',
        'categoryDetails',
        'totalStock',
        'similarProducts',
        'recentlyViewedProducts',
        'groupProducts',
        'ratings',
        'avgRating',
        'avgStarRating',
        'check_ordered_by_current_user',
    ));
}

    public function latest()
    {
        $products = Product::with('attributes')->withAvg('ratings', 'rating')->where('status', 1)->latest()->get();
        $name = "Latest Produts";
        return view('Ecommerce.products.index', compact('products', 'name'));
    }

    public function all(Request $request)
    {
        $auto_scroll_products = Product::with('attributes')->withAvg('ratings', 'rating')->where('status', 1)
            ->latest()
            ->paginate(12);

        if ($request->ajax()) {
            return view('Ecommerce.products._product_card', compact('auto_scroll_products'))->render();
        }

        return view('Ecommerce.products.autoload', compact('auto_scroll_products'));
    }


    public function featured()
    {
        $products = Product::with('attributes')->withAvg('ratings', 'rating')->where('is_Featured', 'Yes')->where('status', 1)->inRandomOrder()->get();
        $name = "Featured Produts";

        return view('Ecommerce.products.index', compact('products', 'name'));
    }

    public function discounted()
    {
        $products = Product::with('attributes')->withAvg('ratings', 'rating')->where('product_discount', '>', 0)->where('status', 1)->inRandomOrder()->get();
        $name = "Discounted Produts";

        return view('Ecommerce.products.index', compact('products', 'name'));
    }

    public function flash(){
        $now = \Carbon\Carbon::now('UTC');
        $featured_flash_deal = FlashDeal::where('status', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->first();

        $flash_deal_products = collect();
        if ($featured_flash_deal) {
            $flash_deal_ids = $featured_flash_deal->pluck('id');
            $flash_deal_products = FlashDealProduct::with('product')->with('attributes')->withAvg('ratings', 'rating')
                ->whereIn('flash_deal_id', $flash_deal_ids)
                ->inRandomOrder()
                ->get();
        }
        $name = "Flash Deal Products";
        return view('Ecommerce.products.flash_sales', compact('flash_deal_products', 'name','featured_flash_deal'));
    }


}
