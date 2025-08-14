<?php

namespace App\Observers;

use App\Models\HotelCategory;
use Illuminate\Support\Facades\Cache;

class HotelCategoryObserver
{
    /**
     * Handle the HotelCategory "created" event.
     */
    public function created(HotelCategory $hotelCategory)
    {
        $this->clearCategoryCache($hotelCategory);
    }

    /**
     * Handle the HotelCategory "updated" event.
     */
    public function updated(HotelCategory $hotelCategory)
    {
        $this->clearCategoryCache($hotelCategory);
    }


    public function deleted(HotelCategory $hotelCategory)
    {
        $this->clearCategoryCache($hotelCategory);
    }

    /**
     * Custom method to clear related cache.
     */
    protected function clearCategoryCache(HotelCategory $hotelCategory)
    {
        // Clear paginated category lists
        for ($page = 1; $page <= 10; $page++) {
            Cache::forget("hotel_categories_page_{$page}");
        }
        // Clear all categories cache
        Cache::forget('hotel_categories_latest');

        Cache::tags(['hotels'])->flush();

        // Clear single category cache
        Cache::forget("hotel_category_{$hotelCategory->id}");

        // Clear hotels in this category cache
        for ($page = 1; $page <= 10; $page++) {
            Cache::forget("hotels_in_category_{$hotelCategory->id}_page_{$page}");
        }
    }
}
