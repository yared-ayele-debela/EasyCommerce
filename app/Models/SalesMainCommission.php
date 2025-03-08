<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesMainCommission extends Model
{
    use HasFactory;
    protected $table="sales_main_commissions";
    protected $fillable=['commission_amount'];
}