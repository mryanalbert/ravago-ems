<?php

namespace App\Policies;

use App\Models\DbUserUsr;
use Illuminate\Auth\Access\Response;

class DbUserUsrPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(DbUserUsr $dbUserUsr): bool
    {
        return $dbUserUsr->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(DbUserUsr $dbUserUsr): bool
    {
        return $dbUserUsr->isSuperAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(DbUserUsr $dbUserUsr): bool
    {
        return $dbUserUsr->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(DbUserUsr $dbUserUsr): bool
    {
        return $dbUserUsr->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(DbUserUsr $dbUserUsr): bool
    {
        return $dbUserUsr->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(DbUserUsr $dbUserUsr): bool
    {
        return $dbUserUsr->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(DbUserUsr $dbUserUsr): bool
    {
        return $dbUserUsr->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteAny(DbUserUsr $dbUserUsr): bool
    {
        return $dbUserUsr->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restoreAny(DbUserUsr $dbUserUsr): bool
    {
        return $dbUserUsr->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDeleteAny(DbUserUsr $dbUserUsr): bool
    {
        return $dbUserUsr->isSuperAdmin();
    }
}
