<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;
    protected $table="appsettings";
    protected $fillable=[
        'application_title',
        'description',
        'address',
        'email_address',
        'phone_no',
        'favicon',
        'logo',
        'language',
        'time_zone','footer_text','facebook','twitter','whatsapp','youtube','created_at','updated_at'
    ];
}
