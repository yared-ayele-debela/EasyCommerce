<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'address', 'city', 'state', 'postal_code', 
        'latitude', 'longitude', 'phone', 'email', 'website', 
        'opening_time', 'closing_time', 'is_open', 'country_id'
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
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function foodCategories()
    {
        return $this->hasManyThrough(
            FoodCategory::class,
            Country::class,
            'id', // Foreign key on Country (from the `countries` table)
            'country_id', // Foreign key on FoodCategory
            'country_id', // Local key on Restaurant
            'id' // Local key on FoodCategory
        );
    }

    public function foods()
    {
        return $this->hasManyThrough(
            Food::class,
            FoodCategory::class,
            'category_id',
            'restaurant_id',
            'id',
            'id'
        );
    }
    
}

