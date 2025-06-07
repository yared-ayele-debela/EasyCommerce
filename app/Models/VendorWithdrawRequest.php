<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorWithdrawRequest extends Model
{
    use HasFactory;

    protected $table="vendor_withdraw_requests";
    protected $fillable=['vendor_id','amount','status','note'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
