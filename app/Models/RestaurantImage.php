<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantImage extends Model
{
    use HasFactory;

    protected $table = 'restaurant_images';

    protected $fillable = [
        'restaurant_id',
        'image_path',
    ];

    /**
     * Get the restaurant that owns the image.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
