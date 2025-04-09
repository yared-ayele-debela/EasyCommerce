<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelReservationPaymentInfo extends Model
{
    use HasFactory;
    protected $table="hotel_reservation_payment_info";
    
    protected $fillable=['reservation_id','user_id','bank_name','transaction_number','receipt','amount_paid','payment_status'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
    
}