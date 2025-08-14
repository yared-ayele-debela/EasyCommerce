<?php

namespace App\Observers;

use App\Models\Vendor;
use Illuminate\Support\Facades\Cache;

class VendorObserver
{
    /**
     * Handle the Vendor "created" event.
     */
    public function created(Vendor $vendor): void
    {
                $this->clearVendorCache($vendor);

    }

    /**
     * Handle the Vendor "updated" event.
     */
    public function updated(Vendor $vendor): void
    {
      $this->clearVendorCache($vendor);

    }

    /**
     * Handle the Vendor "deleted" event.
     */
    public function deleted(Vendor $vendor): void
    {
                $this->clearVendorCache($vendor);

    }

    protected function clearVendorCache(Vendor $vendor)
    {

        // Vendor lists
        Cache::forget('allvendor_ecommerce_active');
        Cache::forget('frontend_allvendor_ecommerce_active');

        Cache::forget('admin_vendors_with_business');

        // Vendor ratings count
        Cache::forget('vendor_ratings_count');

        // Vendor detail pages
        Cache::forget("vendor_detail_{$vendor->id}");

        // Optionally, clear related products and ratings caches if you cache them
        foreach ($vendor->products as $product) {
            Cache::forget("product_{$product->id}_detail");
            Cache::forget("product_{$product->id}_ratings");
        }
    }
}
