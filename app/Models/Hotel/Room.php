<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table="hotel_rooms";

    protected $fillable = [
        'hotel_id', 'room_type_id', 'total_adult', 'total_child', 'room_capacity',
        'image', 'price', 'size', 'view', 'bed_style', 'discount',
        'short_desc', 'description', 'status'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
    
    public function features() {
        return $this->belongsToMany(RoomFeature::class, 'room_feature', 'room_id', 'feature_id');
    }
}