<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id', 'name', 'description'];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
