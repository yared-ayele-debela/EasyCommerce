<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutOfStockRequest extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'customer_id', 'vendor_id', 'message', 'read_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
   
}
