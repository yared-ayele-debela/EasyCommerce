<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethodPrice extends Model
{
    use HasFactory;
    
    protected $fillable = ['shipping_method_id', 'zone_id', 'price'];

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function zone()
    {
        return $this->belongsTo(ShippingZone::class); // Update the reference model name
    }
}
