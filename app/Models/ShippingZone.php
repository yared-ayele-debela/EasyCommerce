<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'regions'];

    public function methods()
    {
        return $this->belongsToMany(ShippingMethod::class, 'shipping_method_zone');
    }

    public function states(){

        return $this->belongsTo(State::class,'regions');
    }
}