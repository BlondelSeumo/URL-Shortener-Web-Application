@extends('layouts.app')

@section('site_title', __('Reset Password'))

@section('content')
<div class="bg-base-1 flex-fill">
    <div class="container h-100 py-3 my-3">

        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-5">
                <div class="text-center"><h2 class="mb-3 d-inline-block">{{ __('Reset Password') }}</h2></div>

                <div class="card border-0 shadow-sm my-3">
                    <div class="card-body">
                        @if (request()->session()->get('status'))
                            <div class="alert alert-success" role="alert">
                                {{ request()->session()->get('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
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

                            <button type="submit" class="btn btn-block btn-primary">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
