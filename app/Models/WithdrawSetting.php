<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawSetting extends Model
{
    use HasFactory;
    protected $table='withdraw_settings';

    protected $fillable=['amount','status'];
}