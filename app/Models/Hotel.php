<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category_id', 'location', 'latitude', 'longitude',
        'price_per_night', 'banner_image','is_adverted', 'rating', 'reviews_count',
        'discount', 'is_featured', 'phone', 'description','is_adverted'
    ];


    public function category()
    {
        return $this->belongsTo(HotelCategory::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function reviews()
    {
        return $this->hasMany(HotelReview::class);
    }

    public function photos()
    {
        return $this->hasMany(HotelPhoto::class);
    }

    public function hotel_category(){
        return $this->belongsTo(HotelCategory::class);
    }
}