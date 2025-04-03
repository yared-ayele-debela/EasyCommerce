<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'image', 'food_image'];

    public function foodCategories()
    {
        return $this->hasMany(FoodCategory::class, 'country_id');
    }
}
