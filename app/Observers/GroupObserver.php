<?php

namespace App\Observers;

use App\Models\Group;
use Illuminate\Support\Facades\Cache;

class GroupObserver
{
    /**
     * Handle the Group "created" event.
     */
    public function created(Group $group): void
    {
        $this->clearGroupCache();
    }

    /**
     * Handle the Group "updated" event.
     */
    public function updated(Group $group): void
    {
        $this->clearGroupCache();
    }

    /**
     * Handle the Group "deleted" event.
     */
    public function deleted(Group $group): void
    {
        $this->clearGroupCache();
    }

    /**
     * Clear cached group data
     */
    protected function clearGroupCache(): void
    {
        Cache::forget('group_with_categories');
        Cache::forget('top_level_categories_active');
        Cache::tags(['products'])->flush();
    }
}
