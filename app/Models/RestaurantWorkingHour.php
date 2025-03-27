<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantWorkingHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id', 'day_of_week', 'opening_time', 'closing_time'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
