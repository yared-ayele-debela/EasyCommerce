<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table='orders_products';
protected $fillable = [
    'order_id',
    'user_id',
    'vendor_id',
    'order_product_code',
    'admin_id',
    'product_id',
    'product_code',
    'product_name',
    'product_color',
    'product_size',
    'product_price',
    'product_qty',
    'item_status',
    'accepted',
    'courier_name',
    'tracking_number',
    'discount_type',
    'discounted_price',
    'specail_discount',
    'admin_commission',
    'vendor_earning',
];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }


}