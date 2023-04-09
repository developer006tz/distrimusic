<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the order can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list orders');
    }

    /**
     * Determine whether the order can view the model.
     */
    public function view(User $user, Order $model): bool
    {
        return $user->hasPermissionTo('view orders');
    }

    /**
     * Determine whether the order can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create orders');
    }

    /**
     * Determine whether the order can update the model.
     */
    public function update(User $user, Order $model): bool
    {
        return $user->hasPermissionTo('update orders');
    }

    /**
     * Determine whether the order can delete the model.
     */
    public function delete(User $user, Order $model): bool
    {
        return $user->hasPermissionTo('delete orders');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete orders');
    }

    /**
     * Determine whether the order can restore the model.
     */
    public function restore(User $user, Order $model): bool
    {
        return false;
    }

    /**
     * Determine whether the order can permanently delete the model.
     */
    public function forceDelete(User $user, Order $model): bool
    {
        return false;
    }
}
