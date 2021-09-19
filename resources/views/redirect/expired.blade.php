@extends('layouts.redirect')

@section('site_title', __('Link expired'))

@section('content')
<div class="bg-base-1 d-flex align-items-center flex-fill">
    <div class="container">
        <div class="row h-100 justify-content-center align-items-center py-3">
            <div class="col-lg-6">
                <h2 class="mb-3 text-center">{{ __('Link expired') }}</h2>
                <p class="text-center text-muted">{{ __('This link has expired.') }}</p>

                @if(url()->previous() != url()->current())
                    <div class="text-center mt-5">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">{{ __('Go back') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection