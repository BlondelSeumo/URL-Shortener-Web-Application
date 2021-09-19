@section('site_title', formatTitle([__('Account'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['title' => __('Account')]
]])

<h2 class="mb-0 d-inline-block">{{ __('Account') }}</h2>

@php
    $settings[] = [
            'icon' => 'icons.account',
            'title' => 'Profile',
            'description' => 'Update your profile information',
            'route' => 'account.profile'
        ];
    $settings[] = [
            'icon' => 'icons.security',
            'title' => 'Security',
            'description' => 'Change your security information',
            'route' => 'account.security'
        ];
    if(paymentProcessors()) {
        $settings[] = [
                'icon' => 'icons.package',
                'title' => 'Plan',
                'description' => 'View your plan details',
                'route' => 'account.plan'
            ];
        $settings[] = [
                'icon' => 'icons.card',
                'title' => 'Payments',
                'description' => 'View your payments and invoices',
                'route' => 'account.payments'
            ];
        }
    $settings[] = [
            'icon' => 'icons.api',
            'title' => 'API',
            'description' => 'View and change your developer key',
            'route' => 'account.api'
        ];
    $settings[] = [
            'icon' => 'icons.delete',
            'title' => 'Delete',
            'description' => 'Delete your account and associated data',
            'route' => 'account.delete'
        ];
@endphp

<div class="row">
    @foreach($settings as $setting)
        <div class="col-12 mt-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-body d-flex align-items-center text-truncate">
                    <div class="d-flex position-relative text-primary width-8 height-8 align-items-center justify-content-center flex-shrink-0">
                        <div class="position-absolute bg-primary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                        @include($setting['icon'], ['class' => 'fill-current width-4 height-4'])
                    </div>

                    <div class="text-dark font-weight-medium font-size-lg mx-3 text-truncate">{{ __($setting['title']) }}</div>

                    <a href="{{ (Route::has($setting['route']) ? route($setting['route']) : $setting['route']) }}"  class="text-secondary stretched-link text-decoration-none d-flex align-items-center text-truncate {{ (__('lang_dir') == 'rtl' ? 'mr-auto' : 'ml-auto') }}">
                        <div class="text-truncate d-none d-md-flex">{{ __($setting['description']) }}</div>

                        @include((__('lang_dir') == 'rtl' ? 'icons.chevron-left' : 'icons.chevron-right'), ['class' => 'text-secondary flex-shrink-0 width-3 height-3 fill-current mx-2'])
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
