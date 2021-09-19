<?php

namespace App\Policies;

use App\User;
use App\Link;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any links.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the link.
     *
     * @param  \App\User  $user
     * @param  \App\Link  $link
     * @return mixed
     */
    public function view(User $user, Link $link)
    {
        //
    }

    /**
     * Determine whether the user can create links.
     *
     * @param \App\User $user
     * @param $limit
     * @return mixed
     */
    public function create(User $user, $limit)
    {
        if ($limit == -1) {
            return true;
        } elseif($limit > 0) {
            // Set the count for multi links counter
            $mCount = 0;

            // If the request is for a multi links creation
            if (request()->input('multi_link')) {
                // Get the links
                $links = preg_split('/\n|\r/', request()->input('urls'), -1, PREG_SPLIT_NO_EMPTY);

                // If the request contains more than one link
                if (count(preg_split('/\n|\r/', request()->input('urls'), -1, PREG_SPLIT_NO_EMPTY)) > 1) {

                    // Get the links count, and subtract 1 value, the remaining will be used to emulate the total links count against the limit
                    $mCount = (count($links)-1);
                }
            }

            $count = Link::where('user_id', '=', $user->id)->count();

            // If the total links count (including multi links, if any in the request) exceeds the limits
            if (($count+$mCount) < $limit) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the link.
     *
     * @param  \App\User  $user
     * @param  \App\Link  $link
     * @return mixed
     */
    public function update(User $user, Link $link)
    {
        //
    }

    /**
     * Determine whether the user can delete the link.
     *
     * @param  \App\User  $user
     * @param  \App\Link  $link
     * @return mixed
     */
    public function delete(User $user, Link $link)
    {
        //
    }

    /**
     * Determine whether the user can restore the link.
     *
     * @param  \App\User  $user
     * @param  \App\Link  $link
     * @return mixed
     */
    public function restore(User $user, Link $link)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the link.
     *
     * @param  \App\User  $user
     * @param  \App\Link  $link
     * @return mixed
     */
    public function forceDelete(User $user, Link $link)
    {
        //
    }

    /**
     * Determine whether the user can use Spaces.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function spaces(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can use Domains.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function domains(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can use Pixels.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function pixels(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can use Stats.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function stats(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can Disable links.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function disabled(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can use Targeting.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function targeting(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can use UTM.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function utm(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can use Password.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function password(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can use Expire.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function expiration(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can use Global Domains.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function globalDomains(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can use Deep Links.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function deepLinks(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can use Data Export.
     *
     * @param User|null $user
     * @param $limit
     * @return bool
     */
    public function dataExport(?User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can use the API.
     *
     * @param User $user
     * @param $limit
     * @return bool
     */
    public function api(User $user, $limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }
}
