@section('site_title', formatTitle([__('General'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('General')],
]])

<h2 class="mb-3 d-inline-block">{{ __('General') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header"><div class="font-weight-medium py-1">{{ __('General') }}</div></div>
    <div class="card-body">

        @include('shared.message')

        <form action="{{ route('admin.general') }}" method="post" enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="i-title">{{ __('Title') }}</label>
                <input type="text" name="title" id="i-title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') ?? config('settings.title') }}">
                @if ($errors->has('title'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-tagline">{{ __('Tagline') }}</label>
                <input type="text" name="tagline" id="i-tagline" class="form-control{{ $errors->has('tagline') ? ' is-invalid' : '' }}" value="{{ old('tagline') ?? config('settings.tagline') }}">
                @if ($errors->has('tagline'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('tagline') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-index">{{ __('Custom index') }}</label>
                <input type="text" dir="ltr" name="index" id="i-index" class="form-control{{ $errors->has('index') ? ' is-invalid' : '' }}" value="{{ old('index') ?? config('settings.index') }}">
                @if ($errors->has('index'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('index') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-paginate">{{ __('Results per page') }}</label>
                <select name="paginate" id="i-paginate" class="custom-select{{ $errors->has('paginate') ? ' is-invalid' : '' }}">
                    @foreach([10, 20, 25, 50, 100] as $value)
                        <option value="{{ $value }}" @if ((old('paginate') !== null && old('paginate') == $value) || (config('settings.paginate') == $value && old('paginate') == null)) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
                @if ($errors->has('paginate'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('paginate') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-timezone">{{ __('Timezone') }}</label>
                <select name="timezone" id="i-timezone" class="custom-select{{ $errors->has('timezone') ? ' is-invalid' : '' }}">
                    @foreach(timezone_identifiers_list() as $value)
                        <option value="{{ $value }}" @if ((old('timezone') !== null && old('timezone') == $value) || (config('settings.timezone') == $value && old('timezone') == null)) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
                @if ($errors->has('timezone'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('timezone') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-tracking-code">{{ __('Tracking code') }}</label>
                <textarea name="tracking_code" id="i-tracking-code" class="form-control{{ $errors->has('tracking_code') ? ' is-invalid' : '' }}">{{ old('tracking_code') ?? config('settings.tracking_code') }}</textarea>
                @if ($errors->has('tracking_code'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('tracking_code') }}</strong>
                    </span>
                @endif
            </div>

            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>

    </div>
</div>