<?php

namespace App\Models;

class HotelReview extends Model
{
    use HasFactory;

    protected $fillable = ['hotel_id', 'user_id', 'rating', 'comment'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}