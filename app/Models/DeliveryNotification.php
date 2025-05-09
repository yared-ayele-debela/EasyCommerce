<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNotification extends Model
{
    use HasFactory;
    protected $table='delivery_notifications';
    protected $fillable=['order_id','delivery_man_id'];
}