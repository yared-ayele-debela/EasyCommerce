<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPaymentInfo extends Model
{
    use HasFactory;
    protected $table="restaurant_orders_payment_info";

    protected $fillable=['restaurant_orders_id','user_id','bank_name','transaction_number','amount_paid','receipt','payment_status'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'restaurant_orders_id');
    }
}