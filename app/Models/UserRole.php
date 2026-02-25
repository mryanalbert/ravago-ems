<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'ems.user_roles';
    protected $primaryKey = 'ur_id';

    protected $fillable = ['ur_user_id', 'ur_role_id'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(DbUserUsr::class, 'ur_user_id', 'userId');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'ur_role_id', 'role_id');
    }
}
