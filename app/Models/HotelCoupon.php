<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelCoupon extends Model
{
    use HasFactory;

    protected $table="hotel_coupons";

    protected $fillable = [
        'admin_id',
        'code',
        'type',         // 'fixed' or 'percent'
        'value',
        'usage_limit',
        'used',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'value' => 'decimal:2',
    ];

    /**
     * Check if the coupon is still valid.
     */
    public function isValid(): bool
    {
        return (!$this->expires_at || $this->expires_at->isFuture())
            && (!$this->usage_limit || $this->used < $this->usage_limit);
    }

    /**
     * Get the discount amount based on type and total.
     */
    public function calculateDiscount($total): float
    {
        if ($this->type === 'fixed') {
            return min($this->value, $total);
        }

        if ($this->type === 'percent') {
            return round(($total * $this->value) / 100, 2);
        }

        return 0;
    }
}