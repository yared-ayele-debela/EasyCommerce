<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{

    public function detail($Id)
    {
        $id = decrypt($Id);
        $product = Product::with([
            'group',
            'category',
            'brand',
            'images',
            'vendor',
            'attributes' => function ($query) {
                $query->where('stock', '>', 0)->where('status', 1);
            }
        ])->where('id', $id)->firstOrFail();

        $productId = $product->id;

        // Category details
        $categoryDetails = Category::categoryDetails($product->category->url);

        // Total available stock
        $totalStock = ProductAttribute::where('product_id', $productId)->sum('stock');

        // Similar products (same category, different product)
        $similarProducts = Product::with('brand')
            ->where('category_id', $product->category->id)
            ->where('id', '!=', $productId)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        // Manage session for recently viewed
        $sessionId = Session::get('session_id') ?? md5(uniqid(rand(), true));
        Session::put('session_id', $sessionId);

        // Insert if not already viewed
        DB::table('recently_viewed_products')->updateOrInsert(
            ['product_id' => $productId, 'session_id' => $sessionId],
            ['product_id' => $productId, 'session_id' => $sessionId]
        );

        // Fetch recently viewed products
        $recentProductIds = DB::table('recently_viewed_products')
            ->where('session_id', $sessionId)
            ->where('product_id', '!=', $productId)
            ->inRandomOrder()
            ->limit(4)
            ->pluck('product_id');

        $recentlyViewedProducts = Product::with('brand')
            ->whereIn('id', $recentProductIds)
            ->get();

        // Group products by color (e.g., color variations)
        $groupProducts = [];
        if (!empty($product->product_color)) {
            $groupProducts = Product::select('id', 'product_image')
                ->where('product_color', $product->product_color)
                ->where('id', '!=', $productId)
                ->where('status', 1)
                ->get();
        }

        // Ratings and average
        $ratings = Rating::with('user')
            ->where('product_id', $productId)
            ->where('status', 1)
            ->orderByDesc('id')
            ->get();

        $ratingsSum = $ratings->sum('rating');
        $ratingsCount = $ratings->count();
        $avgRating = $ratingsCount > 0 ? round($ratingsSum / $ratingsCount, 2) : 0;
        $avgStarRating = $ratingsCount > 0 ? round($ratingsSum / $ratingsCount) : 0;


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
        ));
    }
    public function latest()
    {
        $products = Product::where('status', 1)->inRandomOrder()->get();
        $name = "Latest Produts";
        return view('Ecommerce.products.index', compact('products', 'name'));
    }

    public function featured()
    {
        $products = Product::where('is_Featured', 'Yes')->where('status', 1)->inRandomOrder()->get();
        $name = "Featured Produts";

        return view('Ecommerce.products.index', compact('products', 'name'));
    }

    public function discounted()
    {
        $products = Product::where('product_discount', '>', 0)->where('status', 1)->inRandomOrder()->get();
        $name = "Discounted Produts";

        return view('Ecommerce.products.index', compact('products', 'name'));
    }
}
