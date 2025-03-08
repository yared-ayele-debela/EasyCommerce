<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;
    protected $fillable = ['vendor_id', 'amount', 'status','receipt','description'];

    public function vendor()
    {
        return $this->belongsTo(Admin::class, 'vendor_id');
    }

}