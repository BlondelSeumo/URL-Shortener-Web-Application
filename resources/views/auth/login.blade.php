@extends('layouts.auth')

@section('site_title', formatTitle([__('Login'), config('settings.title')]))

@section('content')
<div class="bg-base-1 d-flex align-items-center flex-fill">
    <div class="container h-100 py-3 my-3">

        <div class="text-center"><h2 class="mb-3 d-inline-block d-block d-lg-none">{{ __('Login') }}</h2></div>

        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-12">
                <div class="card border-0 shadow-sm my-3 overflow-hidden">
                    <div class="row no-gutters">
                        <div class="col-12 col-lg-5">
                            <div class="card-body p-lg-5">
                                <a href="{{ route('home') }}" aria-label="{{ config('settings.title') }}" class="navbar-brand p-0 mb-4 d-none d-lg-block">
                                    <div class="logo">
                                        <img src="{{ url('/') }}/uploads/brand/{{ config('settings.logo') }}">
                                    </div>
                                </a>

                                <form method="POST" action="{{ route('login') }}">
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
                                        <label for="i-password">{{ __('Password') }}</label>
                                        <input id="i-password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-6">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="custom-control-label" for="remember">
                                                    {{ __('Remember me') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 {{ (__('lang_dir') == 'rtl' ? 'text-left' : 'text-right') }}">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}">
                                                    {{ __('Forgot password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-block btn-primary py-2">
                                        {{ __('Login') }}
                                    </button>
                                </form>
                            </div>
                            @if(config('settings.registration'))
                                <div class="card-footer bg-base-2 border-0">
                                    <div class="text-center text-muted my-2">{{ __('Don\'t have an account?') }} <a href="{{ route('register') }}" role="button">{{ __('Register') }}</a></div>
                                </div>
                            @endif
                        </div>
                        <div class="col-12 col-lg-7 bg-dark background-auth d-none d-lg-flex flex-fill bg-left-bottom bg-cover" style="background-image: url({{ asset('images/login.svg') }})">
                            <div class="card-body p-lg-5 d-flex flex-column flex-fill position-absolute" style="top: 0; right: 0; bottom: 0; left: 0">
                                <div class="d-flex align-items-center d-flex flex-fill">
                                    <div class="text-white-important {{ (__('lang_dir') == 'rtl' ? 'mr-5' : 'ml-5') }}">
                                        <div class="h2 font-weight-bold d-none d-lg-block">
                                            {{ __('Login') }}
                                        </div>
                                        <div class="font-size-lg font-weight-medium">
                                            {{ __('Welcome back') }} —
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
