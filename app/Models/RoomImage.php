<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    protected $table = 'rooms_images';
    protected $fillable = ['room_id', 'image_path'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}