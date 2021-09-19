<?php

namespace App\Policies;

use App\User;
use App\Space;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpacePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any spaces.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the space.
     *
     * @param  \App\User  $user
     * @param  \App\Space  $space
     * @return mixed
     */
    public function view(User $user, Space $space)
    {
        //
    }

    /**
     * Determine whether the user can create spaces.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, $limit)
    {
        if ($limit == -1) {
            return true;
        } elseif($limit > 0) {
            $count = Space::where('user_id', '=', $user->id)->count();

            if ($count < $limit) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the space.
     *
     * @param  \App\User  $user
     * @param  \App\Space  $space
     * @return mixed
     */
    public function update(User $user, Space $space)
    {
        //
    }

    /**
     * Determine whether the user can delete the space.
     *
     * @param  \App\User  $user
     * @param  \App\Space  $space
     * @return mixed
     */
    public function delete(User $user, Space $space)
    {
        //
    }

    /**
     * Determine whether the user can restore the space.
     *
     * @param  \App\User  $user
     * @param  \App\Space  $space
     * @return mixed
     */
    public function restore(User $user, Space $space)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the space.
     *
     * @param  \App\User  $user
     * @param  \App\Space  $space
     * @return mixed
     */
    public function forceDelete(User $user, Space $space)
    {
        //
    }
}
