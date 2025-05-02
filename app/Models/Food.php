<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';
    protected $fillable = [
        'restaurant_id', 'name', 'description', 'price', 'discount', 
        'is_special_offer', 'available','category_id', 'image'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'is_special_offer' => 'boolean',
        'available' => 'boolean','delivery_time'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    
    public function category()
    {
        return $this->belongsTo(FoodCategory::class, 'category_id');
    }
}
