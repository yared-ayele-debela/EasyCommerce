<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table="restaurant_coupons";
    protected $fillable = ['admin_id','name','description','code', 'type', 'value','validated_date','is_active'];
}