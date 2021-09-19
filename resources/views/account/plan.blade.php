@section('site_title', formatTitle([__('Plan'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('account'), 'title' => __('Account')],
    ['title' => __('Plan')]
]])

<h2 class="mb-3 d-inline-block">{{ __('Plan') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('Plan') }}</div></div>
        </div>
    </div>
    <div class="card-body pb-0">
        @include('shared.message')

        <form action="{{ route('account.plan') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12 col-lg-6 mb-3">
                    <div class="text-muted">{{ __('Plan') }}</div>
                    <div>{{ $user->plan->name }}</div>
                </div>

                @if(!$user->planOnDefault())
                    @if($user->plan_payment_processor)
                        <div class="col-12 col-lg-6 mb-3">
                            <div class="text-muted">{{ __('Processor') }}</div>
                            <div>{{ config('payment.processors.' . $user->plan_payment_processor)['name'] }}</div>
                        </div>
                    @endif

                    @if($user->plan_amount && $user->plan_currency && $user->plan_interval)
                        <div class="col-12 col-lg-6 mb-3">
                            <div class="text-muted">{{ __('Amount') }}</div>
                            <div>{{ formatMoney($user->plan_amount, $user->plan_currency) }} {{ $user->plan_currency }} / <span class="text-lowercase">{{ $user->plan_interval == 'month' ? __('Month') : __('Year') }}</span></div>
                        </div>
                    @endif

                    @if($user->plan_recurring_at)
                        <div class="col-12 col-lg-6 mb-3">
                            <div class="text-muted">{{ __('Recurring at') }}</div>
                            <div>{{ $user->plan_recurring_at->tz($user->timezone ?? config('app.timezone'))->format(__('Y-m-d')) }}</div>
                        </div>
                    @endif

                    @if($user->plan_trial_ends_at && $user->plan_trial_ends_at->gt(Carbon\Carbon::now()))
                        <div class="col-12 col-lg-6 mb-3">
                            <div class="text-muted">{{ __('Trial ends at') }}</div>
                            <div>{{ $user->plan_trial_ends_at->tz($user->timezone ?? config('app.timezone'))->format(__('Y-m-d')) }}</div>
                        </div>
                    @endif

                    @if($user->plan_ends_at)
                        <div class="col-12 col-lg-6 mb-3">
                            <div class="text-muted">{{ __('Ends at') }}</div>
                            <div>{{ $user->plan_ends_at->tz($user->timezone ?? config('app.timezone'))->format(__('Y-m-d')) }}</div>
                        </div>
                    @endif
                @endif
            </div>

            @if($user->plan_recurring_at)
                <button type="button" class="btn btn-outline-danger mb-3" data-toggle="modal" data-target="#cancel-modal">{{ __('Cancel') }}</button>
            @endif
        </form>
    </div>
</div>

<div class="modal fade" id="cancel-modal" tabindex="-1" role="dialog" aria-labelledby="cancel-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h6 class="modal-title" id="cancel-modal-label">{{ __('Cancel') }}</h6>
                <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">{{ __('You\'ll continue to have access to the features you\'ve paid for until the end of your billing cycle.') }}</div>
                <div>{{ __('Are you sure you want to cancel :name?', ['name' => $user->plan->name]) }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('account.plan') }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <button type="submit" class="btn btn-danger">{{ __('Cancel') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>