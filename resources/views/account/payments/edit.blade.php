@section('site_title', formatTitle([__('Edit'), __('Payment'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => isset($admin) ? route('admin.dashboard') : route('dashboard'), 'title' => isset($admin) ? __('Admin') : __('Home')],
    ['url' => isset($admin) ? route('admin.payments') : route('account.payments'), 'title' => __('Payments')],
    ['title' => __('Edit')],
]])

<h2 class="mb-3 d-inline-block">{{ __('Edit') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Payment') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body mb-n3">
        @include('shared.message')

        <form action="{{ route('admin.payments.edit', $payment->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-lg-6 mb-3">
                    <div class="text-muted">{{ __('Plan') }}</div>
                    <div>{{ $payment->product->name }}</div>
                </div>

                <div class="col-12 col-lg-6 mb-3">
                    <div class="text-muted">{{ __('Payment ID') }}</div>
                    <div>{{ $payment->payment_id }}</div>
                </div>

                <div class="col-12 col-lg-6 mb-3">
                    <div class="text-muted">{{ __('Processor') }}</div>
                    <div>{{ config('payment.processors.' . $payment->processor)['name'] }}</div>
                </div>

                <div class="col-12 col-lg-6 mb-3">
                    <div class="text-muted">{{ __('Amount') }}</div>
                    <div>{{ formatMoney($payment->amount, $payment->plan->currency) }} {{ $payment->plan->currency }} / <span class="text-lowercase">{{ $payment->interval == 'month' ? __('Month') : __('Year') }}</span></div>
                </div>

                <div class="col-12 col-lg-6 mb-3">
                    <div class="text-muted">{{ __('Status') }}</div>
                    <div>
                        @if($payment->status == 'completed')
                            {{ __('Completed') }}
                        @elseif($payment->status == 'pending')
                            {{ __('Pending') }}
                        @else
                            {{ __('Cancelled') }}
                        @endif
                    </div>
                </div>

                @if((isset($admin) && in_array($payment->status, ['completed', 'cancelled'])) || $payment->status == 'completed')
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="text-muted">{{ __('Invoice') }}</div>
                        <div><a href="{{ (isset($admin) ? route('admin.invoices.show', $payment->id) : route('account.invoices.show', $payment->id)) }}">{{ $payment->invoice_id }}</a></div>
                    </div>
                @endif

                <div class="col-12 col-lg-6 mb-3">
                    <div class="text-muted">{{ __('Created at') }}</div>
                    <div>{{ $payment->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')) }}</div>
                </div>
            </div>

            @if($payment->status == 'pending')
                <div class="row mb-3">
                    @if(isset($admin))
                        <div class="col">
                            <button type="submit" name="status" value="completed" class="btn btn-primary">{{ __('Approve') }}</button>
                        </div>
                    @endif
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#cancel-modal">{{ __('Cancel') }}</button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>

@if(isset($admin))
    @if(isset($payment->user))
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header">
                <div class="row"><div class="col"><div class="font-weight-medium py-1">{{ __('User') }}</div></div><div class="col-auto"><a href="{{ route('admin.users.edit', $payment->user->id) }}" class="btn btn-outline-primary btn-sm">{{ __('Edit') }}</a></div></div>
            </div>
            <div class="card-body mb-n3">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="text-muted">{{ __('Name') }}</div>
                        <div>{{ $payment->user->name }}</div>
                    </div>

                    <div class="col-12 col-lg-6 mb-3">
                        <div class="text-muted">{{ __('Email') }}</div>
                        <div>{{ $payment->user->email }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

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
                {{ __('Are you sure you want to cancel :name?', ['name' => $payment->payment_id]) }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ (isset($admin) ? route('admin.payments.edit', $payment->id) : route('account.payments.edit', $payment->id)) }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <button type="submit" name="status" value="cancelled" class="btn btn-danger">{{ __('Cancel') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>