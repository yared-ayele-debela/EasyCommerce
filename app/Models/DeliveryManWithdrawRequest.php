<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryManWithdrawRequest extends Model
{
    use HasFactory;
    protected $table="delivery_man_withdraw_requests";
    protected $fillable=['delivery_man_id','amount','status','approved_at'];

    public function deliveryMan()
{
    return $this->belongsTo(DeliveryMan::class, 'delivery_man_id');
}

}
