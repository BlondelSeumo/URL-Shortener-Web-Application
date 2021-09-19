@extends('layouts.app')

@section('site_title', formatTitle([__('Pricing'), config('settings.title')]))

@section('content')
<div class="flex-fill">
    <div class="bg-base-1">
        <div class="container py-6">
            @include('shared.message')

            <div class="text-center">
                <h2 class="mb-3 d-inline-block">{{ __('Pricing') }}</h2>
                <div class="m-auto">
                    <p class="text-muted font-weight-normal font-size-lg">{{ __('Simple pricing plans for everyone and every budget.') }}</p>
                </div>
            </div>

            @include('shared.pricing')
        </div>
    </div>
    <div class="bg-base-0">
        <div class="container py-6">
            <div class="text-center">
                <h2 class="d-inline-block">{{ __('Frequently asked questions') }}</h2>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mt-5 h-100">
                    <div class="h5 font-weight-medium">{{ __('What payment methods do you accept?') }}</div>
                    <div class="text-muted">{{ __('We support the following payment methods: :list.', ['list' => implode(', ', array_map(function ($payment) { return __($payment['type']); }, paymentProcessors()))]) }}</div>
                </div>

                <div class="col-12 col-md-6 mt-5 h-100">
                    <div class="h5 font-weight-medium">{{ __('Can I change plans?') }}</div>
                    <div class="text-muted">{{ __('Yes, you can change your plan at any time.') }} {{ __('Upon switching plans, your current subscription will be cancelled immediately.') }}</div>
                </div>

                <div class="col-12 col-md-6 mt-5 h-100">
                    <div class="h5 font-weight-medium">{{ __('Can I cancel my subscription?') }}</div>
                    <div class="text-muted">{{ __('Yes, you can cancel your subscription at any time.') }} {{ __('You\'ll continue to have access to the features you\'ve paid for until the end of your billing cycle.') }}</div>
                </div>

                <div class="col-12 col-md-6 mt-5 h-100">
                    <div class="h5 font-weight-medium">{{ __('What happens when my subscription expires?') }}</div>
                    <div class="text-muted">{{ __('Once your subscription expires, you\'ll lose access to all the subscription features.') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-base-1">
        <div class="container py-6 text-center">
            <div><h2 class="mb-5 d-inline-block">{{ __('Still have questions?') }}</h2></div>

            <a href="{{ route('contact') }}" class="btn btn-primary">{{ __('Contact us') }}</a>
        </div>
    </div>
</div>
@include('shared.sidebars.user')
@endsection
