<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelPhoto extends Model
{
    use HasFactory;

    protected $table = 'hotel_photos';

    protected $fillable = [
        'hotel_id',
        'photo_url',
    ];

    public $timestamps = false;

    // Relationship with the Hotel model
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}