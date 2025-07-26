<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'hotel_id', 'room_id','total_night','check_in_date','check_out_date',
        'total_price','discount_amount','final_price','total_adult','total_child','total_infant','status','payment_status','admin_commission','vendor_earning','is_old'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotel_reservation_payment_info(){

        return $this->hasOne(HotelReservationPaymentInfo::class);
    }
}