<?php

namespace App\Observers\Restaurant;

use App\Models\Restaurant\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    protected $cacheKeys = [
        'restaurant_categories_active_paginated',
        'restaurant_categories_all',
        // dynamic keys for categories & restaurants will be cleared manually
    ];

    protected function clearCache()
    {
        // Clear static category list
        foreach ($this->cacheKeys as $key) {
            Cache::forget($key);
        }
        $categories = Category::pluck('id');
        foreach ($categories as $id) {
            Cache::forget("restaurant_category_{$id}");
        }

        Cache::tags(['restaurant_products'])->flush();

    }

    public function created(Category $category)
    {
        $this->clearCache();
    }

    public function updated(Category $category)
    {
        $this->clearCache();
    }

    public function deleted(Category $category)
    {
        $this->clearCache();
    }
}
