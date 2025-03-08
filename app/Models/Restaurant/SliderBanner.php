<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderBanner extends Model
{
    use HasFactory;

    protected $table="restaurant_slider_banners";
    protected $fillable = ['title', 'image', 'description', 'link', 'is_active'];

}