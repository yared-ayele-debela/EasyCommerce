<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFeature extends Model
{
    use HasFactory;

    protected $table="hotel_room_feature";


    public function rooms() {
        return $this->belongsToMany(Room::class, 'room_feature', 'feature_id', 'room_id');
    }

}
