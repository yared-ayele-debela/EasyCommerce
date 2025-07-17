<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table="roles";
    protected $fillable = [
        'name',
        'group',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'role__permissions','role_id','permission_id');
    }

    public function hasPermission($permission)
    {
        // dd( $this->permissions->contains('name', $permission));
        return $this->permissions->contains('name', $permission);
    }
}