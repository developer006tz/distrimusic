<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the transaction can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list transactions');
    }

    /**
     * Determine whether the transaction can view the model.
     */
    public function view(User $user, Transaction $model): bool
    {
        return $user->hasPermissionTo('view transactions');
    }

    /**
     * Determine whether the transaction can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create transactions');
    }

    /**
     * Determine whether the transaction can update the model.
     */
    public function update(User $user, Transaction $model): bool
    {
        return $user->hasPermissionTo('update transactions');
    }

    /**
     * Determine whether the transaction can delete the model.
     */
    public function delete(User $user, Transaction $model): bool
    {
        return $user->hasPermissionTo('delete transactions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete transactions');
    }

    /**
     * Determine whether the transaction can restore the model.
     */
    public function restore(User $user, Transaction $model): bool
    {
        return false;
    }

    /**
     * Determine whether the transaction can permanently delete the model.
     */
    public function forceDelete(User $user, Transaction $model): bool
    {
        return false;
    }
}
