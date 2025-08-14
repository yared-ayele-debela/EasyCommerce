<?php

namespace App\Observers;

use App\Models\HotelSlider;
use Illuminate\Support\Facades\Cache;

class HotelSliderObserver
{
    /**
     * Handle the HotelSlider "created" event.
     */
public function created(HotelSlider $hotelSlider)
    {
        $this->clearCache();
    }

    /**
     * Handle the HotelSlider "updated" event.
     */
    public function updated(HotelSlider $hotelSlider)
    {
        $this->clearCache();
    }

    /**
     * Handle the HotelSlider "deleted" event.
     */
    public function deleted(HotelSlider $hotelSlider)
    {
        $this->clearCache();
    }

    /**
     * Clear the cache key related to hotel sliders.
     */
    protected function clearCache()
    {
        Cache::forget('hotel_slider_active');

        // If using cache tags:
        // Cache::tags('hotel_slider')->flush();
    }
}
