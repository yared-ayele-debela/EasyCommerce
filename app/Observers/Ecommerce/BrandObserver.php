<?php

namespace App\Observers\Ecommerce;

use App\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    /**
     * Handle the Brand "created" event.
     */
    public function created(Brand $brand): void
    {
        //
        $this->clearBrandCache();
    }

    /**
     * Handle the Brand "updated" event.
     */
    public function updated(Brand $brand): void
    {
        $this->clearBrandCache();
    }

    /**
     * Handle the Brand "deleted" event.
     */
    public function deleted(Brand $brand): void
    {
        $this->clearBrandCache();
    }

    /**
     * Handle the Brand "restored" event.
     */
    public function restored(Brand $brand): void
    {
        // Optionally, you can clear the cache if needed
        $this->clearBrandCache();
    }

    /**
     * Handle the Brand "force deleted" event.
     */
    public function forceDeleted(Brand $brand): void
    {
        $this->clearBrandCache();
    }
    /**
     * Handle the Brand "archived" event.
     */
    protected function clearBrandCache(): void
    {
        Cache::tags(['products', 'brands'])->flush();

    }
}
