<?php

namespace App\Observers\Restaurant;

use App\Models\Restaurant\Restaurant;
use Illuminate\Support\Facades\Cache;

class RestaurantObserver
{
    /**
     * Handle the Restaurant "created" event.
     */
    private function clearRestaurantCaches($restaurantId = null)
{
    Cache::forget('restaurants_page_1');
    Cache::forget('auto_restaurants_page_1');
    Cache::forget('restaurants_cities');
    Cache::forget('restaurants_states');
    Cache::forget('restaurants_zones');
    Cache::forget('restaurants_fees');
    Cache::forget('restaurants_ajax_page_1');

    Cache::forget('restaurants_open');

    Cache::tags(['restaurant_products'])->flush();

     if ($restaurantId) {
            Cache::forget("restaurant_detail_{$restaurantId}");
            Cache::forget("restaurant_categories_{$restaurantId}");
            // Clear products cache for all categories (optional: you may loop over categories if needed)
            Cache::forget("restaurant_products_{$restaurantId}_category_");
        }
}

    public function created(Restaurant $restaurant): void
    {
        //
            $this->clearRestaurantCaches($restaurant->id);

    }

    /**
     * Handle the Restaurant "updated" event.
     */
    public function updated(Restaurant $restaurant): void
    {
        //
            $this->clearRestaurantCaches($restaurant->id);

    }

    /**
     * Handle the Restaurant "deleted" event.
     */
    public function deleted(Restaurant $restaurant): void
    {
        //
            $this->clearRestaurantCaches($restaurant->id);

    }

    /**
     * Handle the Restaurant "restored" event.
     */
    public function restored(Restaurant $restaurant): void
    {
        //
            $this->clearRestaurantCaches($restaurant->id);

    }

    /**
     * Handle the Restaurant "force deleted" event.
     */
    public function forceDeleted(Restaurant $restaurant): void
    {
        //
            $this->clearRestaurantCaches($restaurant->id);

    }
}
