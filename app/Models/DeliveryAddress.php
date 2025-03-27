<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class DeliveryAddress extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id', 'name', 'address', 'city', 'sub_city', 'street',
      'state', 'country', 'pincode', 'mobile', 'latitude', 'longitude'
    ];
    protected $table='delivery_address';

    public static function deliveryAddresses(){
    $deliveryAddresses=DeliveryAddress::where('user_id',Auth::user()->id)->get()->toArray();

    return $deliveryAddresses;
 }

 public function user()
    {
        return $this->belongsTo(User::class);
    }

}
