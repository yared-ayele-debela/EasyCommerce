<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    protected $table="shipping_charges";
    protected $fillable=['zone','0_500g','501_1000g','1001_2000g','2001_5000g','above_5000g'];

    use HasFactory;

    // app/Models/ShippingCharge.php
    public static function getShippingCharges($totalWeight, $zone)
    {
        $zone = trim($zone); // removes leading/trailing whitespace and hidden characters
        $shipping = ShippingCharge::where('zone', $zone)->first();
        if (!$shipping || $totalWeight <= 0) {
            return 0;
        }

        return match (true) {
            $totalWeight <= 500 => $shipping->{"0_500g"},
            $totalWeight <= 1000 => $shipping->{"501_1000g"},
            $totalWeight <= 2000 => $shipping->{"1001_2000g"},
            $totalWeight <= 5000 => $shipping->{"2001_5000g"},
            $totalWeight > 5000 => $shipping->{"above_5000g"},
            default => 0,
        };
    }

}