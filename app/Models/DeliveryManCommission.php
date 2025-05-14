<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryManCommission extends Model
{
    use HasFactory;

    protected $table="delivery_man_commission";
    protected $fillable=['delivery_man_id','order_type','order_id','commission_amount','status'];
}