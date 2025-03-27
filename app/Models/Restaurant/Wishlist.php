<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table="restaurant_wishlists";

    protected $fillable = ['user_id', 'product_id'];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}