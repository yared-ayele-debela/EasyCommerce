<?php

namespace App\Observers;

use App\Models\Hotel;
use Illuminate\Support\Facades\Cache;

class HotelObserver
{
    /**
     * Handle the Hotel "created" event.
     */
    protected $globalCacheKeys = [
        'discounted_hotels_latest',
        'active_hotels_latest',
        'cities_all',
        'countries_all',
        'states_all',
        'hotel_categories_all',
    ];

    protected function clearCache(Hotel $hotel)
    {
        // Clear global caches
        foreach ($this->globalCacheKeys as $key) {
            Cache::forget($key);
        }

        Cache::tags(['rooms'])->flush();

        // Clear single hotel caches
        Cache::forget("hotel_with_rooms_{$hotel->id}");
        Cache::forget("hotel_gallery_{$hotel->id}");

        // Clear discounted hotels pagination caches
        for ($page = 1; $page <= 10; $page++) { // adjust max pages if needed
            Cache::forget("discounted_hotels_paginated_page_{$page}");
        }

        // If you have any location-based nearby caches (optional)
        Cache::forget("nearby_hotels_for_{$hotel->id}");
    }

    public function created(Hotel $hotel)
    {
        $this->clearCache($hotel);
    }

    public function updated(Hotel $hotel)
    {
        $this->clearCache($hotel);
    }

    public function deleted(Hotel $hotel)
    {
        $this->clearCache($hotel);
    }
}
