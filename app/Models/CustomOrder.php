<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOrder extends Model
{
    use HasFactory;
    protected $table="custom_order";
    protected $fillable=[
        'user_code',
        'customer_name',
        'order_number',
        'phone_number',
    ];

    public function custom_order_product()
    {
        return $this->hasMany(CustomOrderProduct::class, 'order_id');
    }
    public function deliveryBoy()
    {
        return $this->belongsTo(DeliveryMan::class);
    }




}
