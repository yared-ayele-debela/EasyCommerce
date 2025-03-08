<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignStockProduct extends Model
{
    use HasFactory;
    protected $table="assign_stock_product_to_delivery";

    public function transfer_stock_product() {
        return $this->belongsTo(Transfer_stock_product::class);
    }

    // Define relationship with delivery man
    public function deliveryMan() {
        return $this->belongsTo(DeliveryMan::class);
    }
}
