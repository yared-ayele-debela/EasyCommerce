<?php

namespace App\Observers;

use App\Models\Room;
use Illuminate\Support\Facades\Cache;

class RoomObserver
{
    /**
     * Handle the Room "created" event.
     */
   protected $globalCacheKeys = [
        'available_rooms_latest', // list of latest available rooms
    ];

    /**
     * Clear all relevant caches for this room.
     */
    protected function clearCache(Room $room)
    {
        // Clear global caches
        foreach ($this->globalCacheKeys as $key) {
            Cache::forget($key);
        }

        // Clear single room cache
        Cache::forget("room_with_details_{$room->id}");

        // Clear filter/search results cache if used
        for ($page = 1; $page <= 10; $page++) {
            Cache::forget("filtered_rooms_page_{$page}");
        }

        // Clear related hotel cache (optional)
        if ($room->hotel_id) {
            Cache::forget("hotel_with_rooms_{$room->hotel_id}");
        }
    }

    public function created(Room $room)
    {
        $this->clearCache($room);
    }

    public function updated(Room $room)
    {
        $this->clearCache($room);
    }

    public function deleted(Room $room)
    {
        $this->clearCache($room);
    }

}
