<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOrderProduct extends Model
{
    use HasFactory;
    protected $table="custom_order_products";
    protected $fillable=[
        'vendor_code',
        'product_name',
        'quantity',
        'description',
        'delivery_address',
        'order_id'
    ];

    public function custom_order()
    {
        return $this->belongsTo(CustomOrder::class);
    }

}
