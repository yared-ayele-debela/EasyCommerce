<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    use HasFactory;

    protected $fillable = ['country_id', 'parent_cat_id', 'category_name', 'description', 'image'];

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(FoodCategory::class, 'parent_cat_id');
    }

    public function subCategories()
    {
        return $this->hasMany(FoodCategory::class, 'parent_cat_id');
    }

    public function foods()
    {
        return $this->hasMany(Food::class, 'category_id');
    }
}
