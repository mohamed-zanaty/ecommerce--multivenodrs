<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{


    protected $fillable = ['name', 'email', 'password', 'role_id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        $this->belongsTo(Role::class, 'role_id');
    }

    public function hasAbility($permissions)
    {
        $role = $this->role;
        if (!$role)
            return false;
        foreach ($role->permissions as $permission) {
            if (is_array($permissions) and in_array($permission, $permissions))
                return true;
            elseif (is_string($permissions) and strcmp($permissions, $permission) == 0)
                return true;
        }
        return false;
    }

}
