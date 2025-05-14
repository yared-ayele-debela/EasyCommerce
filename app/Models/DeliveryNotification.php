<?php

namespace App\Models;

use App\Models\Restaurant\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNotification extends Model
{
    use HasFactory;
    protected $table='delivery_notifications';
    protected $fillable=['order_id','delivery_man_id'];

    public function order(){

        return $this->belongsTo(Order::class,'order_id');
    }
    public function deliveryman(){

        return $this->belongsTo(DeliveryMan::class,'delivery_man_id');
    }
}
