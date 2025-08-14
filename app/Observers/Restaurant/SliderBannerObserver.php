<?php

namespace App\Observers\Restaurant;

use App\Models\Restaurant\SliderBanner;
use Illuminate\Support\Facades\Cache;

class SliderBannerObserver
{
    /**
     * Handle the SliderBanner "created" event.
     */
    protected $cacheKeys = [
        'slider_banners_active',
    ];

    /**
     * Clear all related caches.
     */
    protected function clearCache()
    {
        foreach ($this->cacheKeys as $key) {
            Cache::forget($key);
        }
    }

    public function created(SliderBanner $banner)
    {
        $this->clearCache();
    }

    public function updated(SliderBanner $banner)
    {
        $this->clearCache();
    }

    public function deleted(SliderBanner $banner)
    {
        $this->clearCache();
    }
}
