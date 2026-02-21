<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';

    protected $fillable = ['role_code', 'role_name'];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'ur_role_id', 'role_id');
    }
}
