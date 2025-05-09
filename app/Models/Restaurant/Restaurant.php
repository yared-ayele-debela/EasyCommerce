<?php

namespace App\Models\Restaurant;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id', 'name', 'email', 'phone', 'address','cover','description','logo', 'latitude', 'longitude', 'is_open'
    ];

    // Relationship with User (Admin/Restaurant Owner)
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function images()
    {
        return $this->hasMany(RestaurantImage::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'restaurant_id');
    }
    public function ratings()
{
    return $this->hasMany(RestaurantRating::class);
}
}
