<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    use HasFactory;

    protected $fillable = ['sub_city_id', 'name'];

    public function subCity()
    {
        return $this->belongsTo(SubCity::class);
    }
}