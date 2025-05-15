<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    use HasFactory;
    protected $table="orders_logs";
    protected $fillable=['order_id','order_status'];

    public function orders_products(){
        return $this->hasMany('App\Models\OrderProduct','id','order_item_id');
    }

    public static function getItemDetails($order_item_id){

        $getItemDetails=OrderProduct::where('id',$order_item_id)->first()->toArray();

        return $getItemDetails;
    }


}