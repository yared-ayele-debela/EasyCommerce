<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantMenu extends Model
{
    use HasFactory;
    protected $table = 'restaurant_menus';

    protected $fillable = ['name', 'slug','image','is_active'];

    
}