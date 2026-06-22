<?php

namespace App\Policies;

use App\Models\CashClose;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CashClosePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CashClose $cashClose): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('comptable')) {
            return true;
        }

        if ($user->hasRole('superviseur')) {
            return $cashClose->agency_id === $user->agency_id;
        }

        if ($user->hasRole('caissier')) {
            return $cashClose->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('caissier');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CashClose $cashClose): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CashClose $cashClose): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can validate the model.
     */
    public function validate(User $user, CashClose $cashClose): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('superviseur')) {
            return $cashClose->agency_id === $user->agency_id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CashClose $cashClose): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CashClose $cashClose): bool
    {
        return $user->hasRole('admin');
    }
}
