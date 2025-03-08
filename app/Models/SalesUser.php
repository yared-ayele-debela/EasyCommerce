<?php

namespace App\Models;

use App\Notifications\SalesUserResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class SalesUser extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password','referral_token','address','phone','image','status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function generateReferralToken()
    {
        $this->referral_token = Str::random(40);
        $this->save();
    }
}