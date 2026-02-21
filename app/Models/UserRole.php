<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $connection = 'mysql';
    protected $table = 'ems.user_roles';
    protected $primaryKey = 'ur_id';

    protected $fillable = [
        'ur_user_id',
        'ur_role_id',
        'ur_is_active',
        'ur_update_note',
        'ur_created_by',
        'ur_created_ts',
        'ur_updated_ts'
    ];

    public function users()
    {
        return $this->belongsTo(DbUserUsr::class, 'ur_user_id', 'userId');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'ur_role_id', 'role_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(DbUserUsr::class, 'ur_created_by', 'userId');
    }

    public $timestamps = false;
}
