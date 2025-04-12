<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomPhoto extends Model
{
    use HasFactory;

    protected $table = 'room_photos'; // your table name

    protected $primaryKey = 'id'; // your primary key

    public $timestamps = false; // because you only have created_at (no updated_at)

    protected $fillable = [
        'room_id',
        'photo_url',
        'caption',
        'created_at',
    ];

    // Relationships
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}
