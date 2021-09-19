@extends('layouts.app')

@section('site_title', formatTitle([__('Contact us'), config('settings.title')]))

@section('content')
    <div class="bg-base-1 flex-fill">
        <div class="container h-100 py-6">

            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-5">
                    <div class="text-center">
                        <h2 class="mb-3 d-inline-block">{{ __('Contact us') }}</h2>
                        <div class="m-auto">
                            <p class="text-muted font-weight-normal font-size-lg mb-5">{{ __('Get in touch with us.') }}</p>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm my-3">
                        <div class="card-body">
                            @include('shared.message')

                            <form method="POST" action="{{ route('contact') }}" id="contact-form">
                                @csrf

                                <div class="form-group">
                                    <label for="i-email">{{ __('Email address') }}</label>
                                    <input id="i-email" type="text" dir="ltr" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="i-subject">{{ __('Subject') }}</label>
                                    <input id="i-subject" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="subject" value="{{ old('subject') }}" autofocus>
                                    @if ($errors->has('subject'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="i-message">{{ __('Message') }}</label>
                                    <textarea name="message" id="i-message" class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}">{{ old('message') }}</textarea>
                                    @if ($errors->has('message'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                @if(config('settings.captcha_contact'))
                                    {!! NoCaptcha::displaySubmit('contact-form', __('Send'), ['data-theme' => (request()->cookie('dark_mode') == 1 ? 'dark' : 'light'), 'data-size' => 'invisible', 'class' => 'btn btn-block btn-primary']) !!}

                                    {!! NoCaptcha::renderJs(__('lang_code')) !!}
                                @else
                                    <button type="submit" class="btn btn-block btn-primary">
                                        {{ __('Send') }}
                                    </button>
                                @endif

                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@include('shared.sidebars.user')