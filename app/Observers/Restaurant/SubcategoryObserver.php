<?php

namespace App\Observers\Restaurant;

use App\Models\Restaurant\Subcategory;

class SubcategoryObserver
{
    /**
     * Handle the Subcategory "created" event.
     */
    public function created(Subcategory $subcategory): void
    {
                        \Illuminate\Support\Facades\Cache::tags(['restaurant_products'])->flush();

    }

    /**
     * Handle the Subcategory "updated" event.
     */
    public function updated(Subcategory $subcategory): void
    {
                        \Illuminate\Support\Facades\Cache::tags(['restaurant_products'])->flush();

    }

    /**
     * Handle the Subcategory "deleted" event.
     */
    public function deleted(Subcategory $subcategory): void
    {
                        \Illuminate\Support\Facades\Cache::tags(['restaurant_products'])->flush();

    }

    /**
     * Handle the Subcategory "restored" event.
     */
    public function restored(Subcategory $subcategory): void
    {
                        \Illuminate\Support\Facades\Cache::tags(['restaurant_products'])->flush();

    }

    /**
     * Handle the Subcategory "force deleted" event.
     */
    public function forceDeleted(Subcategory $subcategory): void
    {
                        \Illuminate\Support\Facades\Cache::tags(['restaurant_products'])->flush();

    }
}
