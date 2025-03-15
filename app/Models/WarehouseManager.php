<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseManager extends Model
{
    use HasFactory;
    protected $table="manager_warehouse";
    protected  $fillable=['warehouse_id','manager_id'];

    public function admin() {
        return $this->belongsTo(Admin::class, 'manager_id','id');
    }

    public function warehouse(){
        return $this->belongsTo(WereHouses::class,'warehouse_id','id');
    }
}