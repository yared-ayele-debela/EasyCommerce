<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFeatures extends Model
{
    use HasFactory;
    
    protected $table="hotel_room_features";

    protected $fillable = ['name', 'description'];

}