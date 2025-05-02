<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'favoritable_id',
        'favoritable_type',
    ];

    /**
     * Get the parent favoritable model (restaurant, food, hotel, etc.).
     */
    public function favoritable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who added the favorite.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
