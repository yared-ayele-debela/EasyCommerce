<?php

namespace App\Models\Restaurant;

use App\Models\DeliveryAddress;
use App\Models\DeliveryMan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table="restaurant_orders";
    protected $fillable = ['user_id', 'subtotal', 'discount', 'delivery_fee', 'total','tax','tip_amount','delivery_man_id','delivery_code','status','delivery_status','payment_status', 'payment_method', 'delivery_address_id','address','city','sub_city','street','satate','mobile','latitude','longitude','is_old','is_call_center'];

        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function address(){

        return $this->belongsTo(DeliveryAddress::class,'delivery_address_id');
    }
    public function paymentInfo()
    {
        return $this->hasOne(OrderPaymentInfo::class,'restaurant_orders_id');
    }
    public function deliveryman(){
        return $this->belongsTo(DeliveryMan::class,'delivery_man_id');
    }
}
