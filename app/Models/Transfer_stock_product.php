<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer_stock_product extends Model
{
    use HasFactory;
    protected $table="transfer_stock_products";
    protected  $fillable=[
        'from_warehouse_id',
        'to_warehouse_id',
        'product_id',
        'quantity',
        'notes',
        'transfer_date'
  ];

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

  public function assignstockproducts() {
    return $this->hasMany(AssignStockProduct::class);
    }

}
