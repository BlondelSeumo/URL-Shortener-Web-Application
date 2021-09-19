<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        if ($user->isForceDeleting()) {
            $user->domains()->delete();
            $user->spaces()->delete();
            $user->stats()->delete();
            $user->linksPixels()->delete();
            $user->pixels()->delete();
            $user->links()->delete();

            // If the user previously had a subscription, attempt to cancel it
            if ($user->plan_subscription_id) {
                $user->planSubscriptionCancel();
            }
        } else {
            // If the user previously had a subscription, attempt to cancel it
            if ($user->plan_subscription_id) {
                $user->planSubscriptionCancel();
            }
        }
    }
}
