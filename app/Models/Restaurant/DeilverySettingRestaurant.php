<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeilverySettingRestaurant extends Model
{
    use HasFactory;

    protected $table="delivery_settings_restaurant";
    protected $fillable = ['base_amount','fee_per_km'];
}
