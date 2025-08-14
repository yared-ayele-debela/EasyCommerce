<?php

namespace App\Observers\Restaurant;

use App\Models\Restaurant\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    private function clearRestaurantCaches(Product $product = null)
{
    Cache::forget('restaurant_products_with_discount');
    Cache::forget('restaurant_most_popular_products');
    Cache::forget('restaurant_best_seller_products');
    Cache::forget('restaurant_latest_products');
    Cache::forget('restaurant_products_active');

    
    if ($product) {
        Cache::forget("restaurant_product_detail_{$product->id}");
        Cache::forget("restaurant_related_products_{$product->id}");
    }
}


    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product)
    {
        $this->clearRestaurantCaches();
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product)
    {
        $this->clearRestaurantCaches();
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product)
    {
        $this->clearRestaurantCaches();
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product)
    {
        $this->clearRestaurantCaches();
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product)
    {
        $this->clearRestaurantCaches();
    }
}
