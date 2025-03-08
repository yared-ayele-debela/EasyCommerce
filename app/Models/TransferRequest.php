<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    use HasFactory;
    protected $table="transfer_requests";

    public function fromWarehouse()
    {
        return $this->belongsTo(WereHouses::class, 'from_warehouse_id');
    }

    // Relationship with the destination warehouse
    public function toWarehouse()
    {
        return $this->belongsTo(WereHouses::class, 'to_warehouse_id');
    }
    // Relationship with the transferred product
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
