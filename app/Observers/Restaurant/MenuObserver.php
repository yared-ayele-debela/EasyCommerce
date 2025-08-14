<?php

namespace App\Observers\Restaurant;

use App\Models\Restaurant\RestaurantMenu;
use Cache;

class MenuObserver
{
    /**
     * Handle the RestaurantMenu "created" event.
     */
    public function created(RestaurantMenu $restaurantMenu): void
    {
        \Illuminate\Support\Facades\Cache::tags(['restaurant_products'])->flush();

    }

    /**
     * Handle the RestaurantMenu "updated" event.
     */
    public function updated(RestaurantMenu $restaurantMenu): void
    {
         \Illuminate\Support\Facades\Cache::tags(['restaurant_products'])->flush();

    }

    /**
     * Handle the RestaurantMenu "deleted" event.
     */
    public function deleted(RestaurantMenu $restaurantMenu): void
    {
                        \Illuminate\Support\Facades\Cache::tags(['restaurant_products'])->flush();

    }

    /**
     * Handle the RestaurantMenu "restored" event.
     */
    public function restored(RestaurantMenu $restaurantMenu): void
    {
                        \Illuminate\Support\Facades\Cache::tags(['restaurant_products'])->flush();

    }

    /**
     * Handle the RestaurantMenu "force deleted" event.
     */
    public function forceDeleted(RestaurantMenu $restaurantMenu): void
    {
                        \Illuminate\Support\Facades\Cache::tags(['restaurant_products'])->flush();

    }
}
