<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryManTip extends Model
{
    use HasFactory;

    protected $table="delivery_man_tips";
    protected $fillable=['delivery_man_id','order_type','order_id','tip_amount','status'];
}
