<?php

namespace App\Observers\Ecommerce;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
   public function created(Product $product): void
    {
        $this->clearProductCache();
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $this->clearProductCache();
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $this->clearProductCache();
    }

    /**
     * Clear all tagged product caches
     */
    protected function clearProductCache(): void
    {
        Cache::tags(['products'])->flush();
        // If a category is updated
        Cache::tags(['products', 'categories'])->flush();
        // If a brand is updated
        Cache::tags(['products', 'brands'])->flush();

    }
}
