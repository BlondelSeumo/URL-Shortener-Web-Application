@extends('layouts.app')

@section('site_title', formatTitle([Str::ucfirst(mb_strtolower(__('Verify Account'))), config('settings.title')]))

@section('content')
<div class="bg-base-1 d-flex align-items-center flex-fill">
    <div class="container">
        <div class="h-100 d-flex flex-column justify-content-center align-items-center my-5">
            @if (request()->session()->get('resent'))
                <div class="alert alert-success mb-5" role="alert">
                    {{ __('A new verification link has been sent to your email address.') }}
                </div>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 201 201" class="w-100 mx-auto" style="max-width: 8rem;"><circle cx="100" cy="100" r="100" style="fill:#6c63ff;opacity:0.1"/><path d="M150.5,70.5a10,10,0,0,0-10-10h-80a10,10,0,0,0-10,10v60a10,10,0,0,0,10,10h80a10,10,0,0,0,10-10Zm-10,0-40,25-40-25Zm0,60h-80v-50l40,25,40-25Z" style="fill:#6c63ff"/><circle cx="150" cy="141" r="24.5" style="fill:#7a7a7a"/><path d="M138.25,137.75A3.75,3.75,0,1,0,142,141.5,3.76,3.76,0,0,0,138.25,137.75Zm22.5,0a3.75,3.75,0,1,0,3.75,3.75A3.76,3.76,0,0,0,160.75,137.75Zm-11.25,0a3.75,3.75,0,1,0,3.75,3.75A3.76,3.76,0,0,0,149.5,137.75Z" style="fill:#fff"/></svg>

            <div>
                <h5 class="mt-4 text-center">{{ Str::ucfirst(mb_strtolower(__('Verify Account'))) }}</h5>
                <p class="text-center text-muted">{{ __('Verify your account by accessing the link sent through email.') }}</p>

                <div class="text-center mt-5">
                    <div class="text-center text-muted">
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}" id="resend-form">
                            @csrf

                            {{ __('Didn\'t received the email?') }} <a href="{{ route('verification.resend') }}" onclick="event.preventDefault(); document.getElementById('resend-form').submit();">{{ __('Resend') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection