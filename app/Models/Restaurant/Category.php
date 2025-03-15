<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Category extends Model
{
    use HasFactory;

    protected $table="restaurant_categories";
    protected $fillable = ['restaurant_id', 'name', 'slug', 'description', 'image', 'is_active', 'discount', 'discount_type'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // Generate a slug from the name
    public static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
}