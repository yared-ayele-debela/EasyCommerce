<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'address', 'city', 'state', 'postal_code', 'country', 
        'phone', 'email', 'website', 'opening_time', 'closing_time', 'is_open'
    ];

    // protected $casts = [
    //     'opening_time' => 'time',
    //     'closing_time' => 'time',
    //     'is_open' => 'boolean',
    // ];

    public function workingHours()
    {
        return $this->hasMany(RestaurantWorkingHour::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
