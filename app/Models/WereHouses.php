<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WereHouses extends Model
{
    use HasFactory;
    protected $table="were_houses";

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'manager_warehouse', 'warehouse_id', 'manager_id');
    }

    public function stocks()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}