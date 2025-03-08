<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    use HasFactory;
    protected $table="currencies";
    protected $fillable = [
        'name',
        'symbol',
        'exchange_rate',
        'code',

    ];
    public $timestamps = true; // Add this line
}
