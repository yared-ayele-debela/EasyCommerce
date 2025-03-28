<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class DeliveryAddress extends Model
{
    use HasFactory;
    protected $fillable=[
      'user_id','name','address','city','state','country','postcode','status','mobile','latitude','longitude','label'  
    ];
    protected $table='delivery_address';
    
    public static function deliveryAddresses(){
    $deliveryAddresses=DeliveryAddress::where('user_id',Auth::user()->id)->get()->toArray();

    return $deliveryAddresses;
 }

}