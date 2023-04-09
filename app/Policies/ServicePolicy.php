<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Service;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the service can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list services');
    }

    /**
     * Determine whether the service can view the model.
     */
    public function view(User $user, Service $model): bool
    {
        return $user->hasPermissionTo('view services');
    }

    /**
     * Determine whether the service can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create services');
    }

    /**
     * Determine whether the service can update the model.
     */
    public function update(User $user, Service $model): bool
    {
        return $user->hasPermissionTo('update services');
    }

    /**
     * Determine whether the service can delete the model.
     */
    public function delete(User $user, Service $model): bool
    {
        return $user->hasPermissionTo('delete services');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete services');
    }

    /**
     * Determine whether the service can restore the model.
     */
    public function restore(User $user, Service $model): bool
    {
        return false;
    }

    /**
     * Determine whether the service can permanently delete the model.
     */
    public function forceDelete(User $user, Service $model): bool
    {
        return false;
    }
}
