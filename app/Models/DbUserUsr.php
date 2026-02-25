<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class DbUserUsr extends Authenticatable
{
    protected $table = 'dbusers.usr';
    protected $primaryKey = 'userId';
    public $incrementing = false;
    protected $keyType = 'string';

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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'ur_user_id', 'ur_role_id');
    }

    public function scopeActiveWithRoles(Builder $query): Builder
    {
        return $query->where('isActive', true)->whereHas('roles');
    }

    public function isSuperAdmin(): bool
    {
        return $this->roles()
            ->where('role_code', 'sa')
            ->exists();
    }
}
