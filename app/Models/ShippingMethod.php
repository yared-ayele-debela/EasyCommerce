<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'base_cost', 'per_kg_rate'];

    public function zones()
    {
        return $this->belongsToMany(ShippingZone::class, 'shipping_method_zone','shipping_method_id', 'shipping_zone_id');
    }

    public function prices()
    {
        return $this->hasMany(ShippingMethodPrice::class);
    }
}
