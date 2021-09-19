<?php

namespace App\Policies;

use App\User;
use App\Domain;
use Illuminate\Auth\Access\HandlesAuthorization;

class DomainPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any domains.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function view(User $user, Domain $domain)
    {
        //
    }

    /**
     * Determine whether the user can create domains.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, $limit)
    {
        if ($limit == -1) {
            return true;
        } elseif($limit > 0) {
            $count = Domain::where('user_id', '=', $user->id)->count();

            if ($count < $limit) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function update(User $user, Domain $domain)
    {
        //
    }

    /**
     * Determine whether the user can delete the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function delete(User $user, Domain $domain)
    {
        //
    }

    /**
     * Determine whether the user can restore the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function restore(User $user, Domain $domain)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function forceDelete(User $user, Domain $domain)
    {
        //
    }
}
