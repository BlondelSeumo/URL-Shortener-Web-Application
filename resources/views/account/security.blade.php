@section('site_title', formatTitle([__('Security'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('account'), 'title' => __('Account')],
    ['title' => __('Security')]
]])

<h2 class="mb-3 d-inline-block">{{ __('Security') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('Security') }}</div></div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('account.security') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-current-password">{{ __('Current password') }}</label>
                <input type="password" name="current_password" id="i-current-password" class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}">
                @if ($errors->has('current_password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('current_password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-password">{{ __('New password') }}</label>
                <input type="password" name="password" id="i-password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-password-confirmation">{{ __('Confirm new password') }}</label>
                <input type="password" name="password_confirmation" id="i-password-confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                @if ($errors->has('password_confirmation'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>

            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>