<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $table="products_attributes";
    protected  $fillable=[
        'product_id',
        'warehouse_id',
        'size',
        'price',
        'stock',
        'sku',
        'status'
  ];

  public function product(){
    return $this->belongsTo(Product::class,'product_id','id');
  }

  public function warehouse() {
    return $this->belongsTo(WereHouses::class, 'warehouse_id'); // Make sure the second argument matches the actual foreign key column name in the product_attributes table
 }

  public static function isStokAvailable($product_id,$size){
    $getProductStrok=ProductAttribute::select('stock')->where(['product_id'=>$product_id,'size'=>$size])->first();
    return $getProductStrok->stock;
  }

  public static function getAttributeStatus($product_id,$size){
    $getProductStatus=ProductAttribute::select('status')->where(['product_id'=>$product_id,'size'=>$size])->first();
    return $getProductStatus->status;
   }
}
