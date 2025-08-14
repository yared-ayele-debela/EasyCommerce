<?php

namespace App\Observers\Ecommerce;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
       public function created(Category $category): void
    {
        $this->clearCategoryCache();
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->clearCategoryCache();
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->clearCategoryCache();
    }

    /**
     * Clear cached top-level categories
     */
    protected function clearCategoryCache(): void
    {
        Cache::forget('top_level_categories_active');
        Cache::tags(['products'])->flush();
        
    }

}
