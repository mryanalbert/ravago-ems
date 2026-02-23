<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class DbUserUsr extends Authenticatable
{
    protected $connection = 'dbusers';
    protected $table = 'usr';
    protected $primaryKey = 'userId';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'email', 'password'];

    public $timestamps = false;

    protected $hidden = ['userPassword'];

    protected $casts = [
        'userPassword' => 'hashed',
    ];

    public function getAuthIdentifierName()
    {
        return $this->primaryKey;
    }

    public function getAuthPassword()
    {
        return $this->userPassword;
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'ur_user_id', 'userId');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function isSuperAdmin(): bool
    {
        return $this->userRoles()
            ->with('roles')
            ->get()
            ->contains(function ($userRole) {
                return $userRole->roles && ($userRole->roles->role_code === 'sa');
            });
    }
}
