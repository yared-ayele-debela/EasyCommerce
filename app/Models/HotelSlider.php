<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelSlider extends Model
{
    use HasFactory;
    protected $table="hotel_slider_banners";
    protected $fillable = ['title', 'image', 'description', 'link', 'is_active'];

}
