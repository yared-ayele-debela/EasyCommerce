<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorWallet extends Model
{
    use HasFactory;
    protected $table="vendor_wallets";


     protected $fillable = [
        'vendor_id',
        'available_balance',
        'pending_balance',
        'total_withdrawn',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function transactions()
    {
        return $this->hasMany(VendorWalletTransaction::class, 'vendor_id', 'vendor_id');
    }
}
