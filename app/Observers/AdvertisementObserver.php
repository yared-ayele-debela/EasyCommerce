<?php

namespace App\Observers;

use App\Models\Advertisement;
use Illuminate\Support\Facades\Cache;

class AdvertisementObserver
{
   protected $cacheKeys = [
        'advert_after_discount_hotels',
        'advert_after_latest_rooms',
        'advert_after_latest_hotels',
        'advert_after_discounted_products',
        'advert_after_featured_products',
        'advert_after_vendors',
        'advert_after_special_offer',
        'advert_after_best_seller',
        'advert_after_all_restaurants',
    ];

    public function clearCache()
    {
        foreach ($this->cacheKeys as $key) {
            Cache::forget($key);
        }
    }

    public function created(Advertisement $advertisement)
    {
        $this->clearCache();
    }

    public function updated(Advertisement $advertisement)
    {
        $this->clearCache();
    }

    public function deleted(Advertisement $advertisement)
    {
        $this->clearCache();
    }
}
