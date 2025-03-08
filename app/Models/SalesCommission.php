<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'salesperson_id',
        'order_id',
        'product_id',
        'amount'
    ];

    public static function getSalespersonIdFromToken($token)
    {
        //To get sales user
        return SalesUser::where('referral_token', $token)->first()->id;
    }

    public function sales(){

        return $this->belongsTo(SalesUser::class,'salesperson_id');
    }

    public function product(){

        return $this->belongsTo(Product::class,'product_id');
    }

    public function order(){

        return $this->belongsTo(order::class,'order_id');
    }
}