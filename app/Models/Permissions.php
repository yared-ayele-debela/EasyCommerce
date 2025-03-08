<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;
    protected $table="permissions";
    protected $fillable = [
        'name',
    ];
    public function category()
    {
        return $this->belongsTo(PermissionCategory::class);
    }

}
