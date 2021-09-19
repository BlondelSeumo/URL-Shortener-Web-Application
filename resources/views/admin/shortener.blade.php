@section('site_title', formatTitle([__('Settings'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('Settings')],
]])

<h2 class="mb-3 d-inline-block">{{ __('Settings') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header"><div class="font-weight-medium py-1">{{ __('Shortener') }}</div></div>
    <div class="card-body">

        @include('shared.message')

        <form action="{{ route('admin.shortener') }}" method="post" enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="i-short-guest">{{ __('Guest shortening') }}</label>
                <select name="short_guest" id="i-short-guest" class="custom-select{{ $errors->has('short_guest') ? ' is-invalid' : '' }}">
                    @foreach([0 => __('Disabled'), 1 => __('Enabled')] as $key => $value)
                        <option value="{{ $key }}" @if ((old('short_guest') !== null && old('short_guest') == $key) || (config('settings.short_guest') == $key && old('short_guest') == null)) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
                @if ($errors->has('short_guest'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('short_guest') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-short-protocol" class="d-flex align-items-center"><span>{{ __('Domains protocol') }}</span> <span data-enable="tooltip" title="{{ __('Use HTTPS only if you are able to generate SSL certificates for the additional domains.') }}" class="d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">@include('icons.info', ['class' => 'fill-current text-muted width-4 height-4'])</span></label>
                <select name="short_protocol" id="i-short-protocol" class="custom-select{{ $errors->has('short_protocol') ? ' is-invalid' : '' }}">
                    @foreach(['http' => 'HTTP', 'https' => 'HTTPS'] as $key => $value)
                        <option value="{{ $key }}" @if ((old('short_protocol') !== null && old('short_protocol') == $key) || (config('settings.short_protocol') == $key && old('short_protocol') == null)) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
                @if ($errors->has('short_protocol'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('short_protocol') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-short-bad-words">{{ __('Bad words') }}</label>
                <textarea name="short_bad_words" id="i-short-bad-words" class="form-control{{ $errors->has('short_bad_words') ? ' is-invalid' : '' }}" rows="3" placeholder="One per line.">{{ config('settings.short_bad_words') }}</textarea>
                @if ($errors->has('short_bad_words'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('short_bad_words') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-short-domain" class="d-flex align-items-center">{{ __('Domain') }} ({{ __('Default') }})</label>
                <select name="short_domain" id="i-short-domain" class="custom-select">
                    <option value="" @if (!config('settings.short_domain')) selected @endif>{{ __('None') }}</option>
                    @foreach($domains as $domain)
                        <option value="{{ $domain->id }}" @if (config('settings.short_domain') == $domain->id) selected @endif>{{ str_replace(['http://', 'https://'], '', $domain->name) }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>

    </div>
</div>