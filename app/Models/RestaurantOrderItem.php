<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantOrderItem extends Model
{
    use HasFactory;

    protected $table = 'restaurant_order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'size',
        'quantity',
        'price',
        'total',
    ];

    public $timestamps = true;

    // Relationships
    public function order()
    {
        return $this->belongsTo(RestaurantOrder::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(RestaurantProduct::class, 'product_id');
    }
}
