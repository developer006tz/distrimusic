<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SocialMediaPlatform;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocialMediaPlatformPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the socialMediaPlatform can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list socialmediaplatforms');
    }

    /**
     * Determine whether the socialMediaPlatform can view the model.
     */
    public function view(User $user, SocialMediaPlatform $model): bool
    {
        return $user->hasPermissionTo('view socialmediaplatforms');
    }

    /**
     * Determine whether the socialMediaPlatform can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create socialmediaplatforms');
    }

    /**
     * Determine whether the socialMediaPlatform can update the model.
     */
    public function update(User $user, SocialMediaPlatform $model): bool
    {
        return $user->hasPermissionTo('update socialmediaplatforms');
    }

    /**
     * Determine whether the socialMediaPlatform can delete the model.
     */
    public function delete(User $user, SocialMediaPlatform $model): bool
    {
        return $user->hasPermissionTo('delete socialmediaplatforms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete socialmediaplatforms');
    }

    /**
     * Determine whether the socialMediaPlatform can restore the model.
     */
    public function restore(User $user, SocialMediaPlatform $model): bool
    {
        return false;
    }

    /**
     * Determine whether the socialMediaPlatform can permanently delete the model.
     */
    public function forceDelete(User $user, SocialMediaPlatform $model): bool
    {
        return false;
    }
}
