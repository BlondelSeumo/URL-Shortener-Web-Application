<?php


namespace App\Traits;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

trait UserTrait
{
    /**
     * Update the User.
     *
     * @param Request $request
     * @param User $user
     * @param null $admin
     * @return User
     */
    protected function userUpdate(Request $request, User $user, $admin = null)
    {
        $user->name = $request->input('name');
        $user->timezone = $request->input('timezone');

        if ($user->email != $request->input('email')) {
            // If email registration site setting is enabled and the request is not from the Admin Panel
            if (config('settings.registration_verification') && $admin == null) {
                // Send send email validation notification
                $user->newEmail($request->input('email'));
            } else {
                $user->email = $request->input('email');
            }
        }

        if ($admin) {
            $user->role = $request->input('role');

            // Update the password
            if (!empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            }

            // Update the email verified status
            if ($request->input('email_verified_at')) {
                $user->markEmailAsVerified();
            } else {
                $user->email_verified_at = null;
            }

            // Update the plan if it has changed
            if ($user->plan != $request->input('plan_id')) {
                $user->plan_id = $request->input('plan_id');
            }

            // Update the plan end's date
            if ($request->input('plan_ends_at')) {
                $endsAt = Carbon::createFromFormat('Y-m-d', $request->input('plan_ends_at'), $user->timezone ?? config('app.timezone'))->tz(config('app.timezone'));

                // If the new date is not the same with the old date
                if (is_null($user->plan_ends_at) || $endsAt->toDateString() != $user->plan_ends_at->toDateString()) {
                    $user->plan_ends_at = $endsAt->toDateTimeString();
                }
            }

            // If changes to the plan have been made
            if ($user->isDirty('plan_id') || $user->isDirty('plan_ends_at')) {
                // If the user previously had a subscription, attempt to cancel it
                if ($user->plan_subscription_id) {
                    $user->planSubscriptionCancel();
                }

                $user->plan_created_at = Carbon::now();
            }
        }

        $user->save();

        return $user;
    }
}