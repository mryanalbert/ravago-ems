<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // protected $connection = 'mysql';
    protected $table = 'ems.roles';
    protected $primaryKey = 'role_id';

    protected $fillable = ['role_code', 'role_name'];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(DbUserUsr::class, 'ems.user_roles', 'ur_role_id', 'ur_user_id');
    }
}
