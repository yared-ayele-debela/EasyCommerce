<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantMenu extends Model
{
    use HasFactory;
    protected $table = 'restaurant_menus';

    protected $fillable = ['name', 'slug','image','is_active'];


   public function products()
{
    return $this->hasMany(Product::class,'menu_id');
}


}
