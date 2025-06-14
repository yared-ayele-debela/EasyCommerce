<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;
    protected $table="restaurant_product_sizes";
    protected $fillable = ['product_id', 'size', 'price', 'stock'];

    // Define the inverse relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // app/Models/ProductSize.php

    public function getFinalPriceAttribute()
    {
        $product = $this->product;
        $category = $product->category ?? null;

        $price = $this->price;

        // Apply product discount first
        if ($product->discount_type && $product->discount > 0) {
            $price = $product->discount_type === 'percentage'
                ? $price - ($price * $product->discount / 100)
                : $price - $product->discount;
        }
        // If no product discount, check for category discount
        elseif ($category && $category->discount_type && $category->discount > 0) {
            $price = $category->discount_type === 'percentage'
                ? $price - ($price * $category->discount / 100)
                : $price - $category->discount;
        }

        return round($price, 2);
    }

}
