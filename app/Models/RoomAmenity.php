<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAmenity extends Model
{
    use HasFactory;
    protected $table="room_amenities";
    protected $fillable = ['rooms_id', 'amenity_id'];

}