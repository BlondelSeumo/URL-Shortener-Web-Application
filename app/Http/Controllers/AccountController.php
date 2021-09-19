<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\UpdateUserPreferencesRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\UpdateUserSecurityRequest;
use App\Payment;
use App\Plan;
use App\Space;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    use UserTrait;

    /**
     * Show the Settings index.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        return view('account.content', ['view' => 'index', 'user' => $request->user()]);
    }

    /**
     * Show the Profile settings form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(Request $request)
    {
        return view('account.content', ['view' => 'profile', 'user' => $request->user()]);
    }

    /**
     * Update the Profile settings.
     *
     * @param UpdateUserProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $this->userUpdate($request, $request->user());

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Resent the Account Email Confirmation request.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendAccountEmailConfirmation(Request $request)
    {
        try {
            $request->user()->resendPendingEmailVerificationMail();
        } catch (\Exception $e) {
            return redirect()->route('account.profile')->with('error', $e->getMessage());
        }

        return back()->with('success', __('A new verification link has been sent to your email address.'));
    }

    /**
     * Cancel the Account Email Confirmation request.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelAccountEmailConfirmation(Request $request)
    {
        $request->user()->clearPendingEmail();

        return back();
    }

    /**
     * Show the Security settings form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function security(Request $request)
    {
        return view('account.content', ['view' => 'security', 'user' => $request->user()]);
    }

    /**
     * Update the Security settings.
     *
     * @param UpdateUserSecurityRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSecurity(UpdateUserSecurityRequest $request)
    {
        $request->user()->password = Hash::make($request->input('password'));
        $request->user()->save();

        Auth::logoutOtherDevices($request->input('password'));

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Show the Plan settings form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function plan(Request $request)
    {
        return view('account.content', ['view' => 'plan', 'user' => $request->user()]);
    }

    /**
     * Update the Plan settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePlan(Request $request)
    {
        $request->user()->planSubscriptionCancel();

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * List the Payments.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexPayments(Request $request)
    {
        $search = $request->input('search');
        $plan = $request->input('plan');
        $interval = $request->input('interval');
        $processor = $request->input('processor');
        $status = $request->input('status');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');
        $by = $request->input('by');

        $payments = Payment::where('user_id', '=', $request->user()->id)
            ->when(isset($plan) && !empty($plan), function($query) use ($plan) {
                return $query->ofPlan($plan);
            })
            ->when($interval, function($query) use($interval) {
                return $query->ofInterval($interval);
            })
            ->when($processor, function($query) use($processor) {
                return $query->ofProcessor($processor);
            })
            ->when($status, function($query) use($status) {
                return $query->ofStatus($status);
            })
            ->when($search, function($query) use ($search, $by) {
                if($by == 'invoice') {
                    return $query->searchInvoice($search);
                }
                return $query->searchPayment($search);
            })
            ->orderBy('id', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'sort' => $sort, 'by' => $by, 'status' => $status, 'interval' => $interval, 'processor' => $processor, 'plan' => $plan]);

        // Get all the plans
        $plans = Plan::where([['amount_month', '>', 0], ['amount_year', '>', 0]])->withTrashed()->get();

        return view('account.content', ['view' => 'payments.list', 'payments' => $payments, 'plans' => $plans]);
    }

    /**
     * Show the edit Payment form.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPayment(Request $request, $id)
    {
        $payment = Payment::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        return view('account.content', ['view' => 'payments.edit', 'payment' => $payment]);
    }

    /**
     * Update the Payment.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updatePayment(Request $request, $id)
    {
        $payment = Payment::where([['id', '=', $id], ['status', '=', 'pending'], ['user_id', '=', $request->user()->id]])->firstOrFail();

        if ($request->input('status') == 'cancelled') {
            $payment->status = $request->input('status');
            $payment->save();
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Show the Invoice.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showInvoice(Request $request, $id)
    {
        $payment = Payment::where([['user_id', '=', $request->user()->id], ['id', '=', $id], ['status', '=', 'completed']])->firstOrFail();

        // Sum the inclusive tax rates
        $inclTaxRatesPercentage = collect($payment->tax_rates)->where('type', '=', 0)->sum('percentage');

        // Sum the exclusive tax rates
        $exclTaxRatesPercentage = collect($payment->tax_rates)->where('type', '=', 1)->sum('percentage');

        return view('account.content', ['view' => 'payments.invoice', 'payment' => $payment, 'inclTaxRatesPercentage' => $inclTaxRatesPercentage, 'exclTaxRatesPercentage' => $exclTaxRatesPercentage]);
    }

    /**
     * Show the API settings form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function api(Request $request)
    {
        return view('account.content', ['view' => 'api', 'user' => $request->user()]);
    }

    /**
     * Update the API settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateApi(Request $request)
    {
        $request->user()->api_token = Str::random(60);
        $request->user()->save();

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Show the Preference settings form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preferences(Request $request)
    {
        // Get the user's spaces
        $spaces = Space::where('user_id', $request->user()->id)->get();

        // Get the user's domains
        $domains = Domain::whereIn('user_id', $request->user()->can('globalDomains', ['App\Link', $request->user()->plan->features->global_domains]) ? [0, $request->user()->id] : [$request->user()->id])->when(config('settings.short_domain'), function($query) { return $query->orWhere('id', '=', config('settings.short_domain')); })->orderBy('name')->get();

        return view('account.content', ['view' => 'preferences', 'domains' => $domains, 'spaces' => $spaces]);
    }

    /**
     * Update the Preferences settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePreferences(UpdateUserPreferencesRequest $request)
    {
        $user = Auth::user();

        $user->default_domain = $request->input('default_domain');
        $user->default_space = $request->input('default_space');
        $user->default_stats = $request->input('default_stats');

        $user->save();

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Show the Delete Account form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Request $request)
    {
        return view('account.content', ['view' => 'delete', 'user' => $request->user()]);
    }

    /**
     * Delete the Account.
     *
     * @param DestroyUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyUser(DestroyUserRequest $request)
    {
        $request->user()->forceDelete();

        return redirect()->route('home');
    }
}
