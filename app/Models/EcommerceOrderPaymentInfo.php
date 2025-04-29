<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcommerceOrderPaymentInfo extends Model
{
    use HasFactory;
    protected $table="ecommerce_orders_payment_info";

    protected $fillable=['orders_id','user_id','bank_name','transaction_number','amount_paid','receipt','payment_status'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }
}