<?php

namespace App\Models\Restaurant;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table="restaurant_products";
    protected $fillable = [
        'name', 'slug', 'description', 'category_id', 'city_id', 'menu_id', 'code',
        'price','product_tax', 'discount_type', 'discount', 'image', 'weight','admin_id',
        'most_populer', 'best_seller','is_free','delivery_fee','delivery_time', 'is_active'
    ];
    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function menu()
    {
        return $this->belongsTo(RestaurantMenu::class);
    }

       // Define the one-to-many relationship with product sizes
       public function sizes()
       {
           return $this->hasMany(ProductSize::class);
       }

    //    public function getFinalPrice()
    //    {
    //        $finalPrice = $this->price;

    //        if ($this->discount_type == 'percentage') {
    //            $finalPrice = $this->price - ($this->price * ($this->discount / 100));
    //        } elseif ($this->discount_type == 'fixed') {
    //            $finalPrice = $this->price - $this->discount;
    //        }

    //        return number_format($finalPrice, 2);
    //    }

       public function getFinalPrice()
{
    $basePrice = $this->price;

    // Priority: product discount > category discount
    if ($this->discount_type && $this->discount > 0) {
        return $this->applyDiscount($basePrice, $this->discount_type, $this->discount);
    }

    if ($this->category && $this->category->discount_type && $this->category->discount > 0) {
        return $this->applyDiscount($basePrice, $this->category->discount_type, $this->category->discount);
    }

    return $basePrice;
}

private function applyDiscount($price, $type, $value)
{
    if ($type === 'percentage') {
        return round($price - ($price * $value / 100), 2);
    } elseif ($type === 'fixed') {
        return round(max(0, $price - $value), 2);
    }

    return $price;
}

       public function ratings()
       {
           return $this->hasMany(ProductRating::class);
       }

       public function admin()
        {
            return $this->belongsTo(Admin::class);
        }

}
