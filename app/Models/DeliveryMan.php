<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OrderProduct;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use PhpParser\Node\Expr\AssignRef;

class DeliveryMan extends Authenticable
{
    use Notifiable;

    use HasFactory;
    protected $guard = "deliverymen";

    protected $table="deliverymen";

    protected $fillable = [
        'first_name', 'email', 'password','total_earn'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function hasPermissionByRole($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    public function assignedOrders()
    {
        return $this->hasMany('App\Models\Order', 'delivery_boy_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'delivery__boy__roles','delivery_boy_id', 'role_id');
    }

    public function assignstockproducts() {
        return $this->hasMany(AssignStockProduct::class);
    }
}
