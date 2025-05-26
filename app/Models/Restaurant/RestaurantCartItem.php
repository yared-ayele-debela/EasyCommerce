<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantCartItem extends Model
{
    use HasFactory;
    protected $table="restaurant_cart_items";
    protected $fillable=['user_id','product_id','size','price','quantity'];
    
}