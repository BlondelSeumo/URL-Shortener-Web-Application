@section('site_title', formatTitle([__('Preferences'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('account'), 'title' => __('Account')],
    ['title' => __('Preferences')]
]])

<div class="d-flex"><h2 class="mb-3 text-break">{{ __('Preferences') }}</h2></div>

<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="font-weight-medium py-1">
            {{ __('Preferences') }}
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('account.preferences') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="i-default-domain">{{ __('Domain') }} ({{ mb_strtolower(__('Default')) }})</label>
                    </div>
                    <div class="col-auto">
                        @cannot('domains', ['App\Link', Auth::user()->plan->features->domains])
                            @if(paymentProcessors())
                                <a href="{{ route('pricing') }}" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'fill-current text-primary width-4 height-4'])</a>
                            @endif
                        @endcannot
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">@include('icons.domain', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                    </div>
                    <select name="default_domain" id="i-default-domain" class="custom-select{{ $errors->has('default_domain') ? ' is-invalid' : '' }}">
                        <option value="">{{ __('None') }}</option>
                        @foreach($domains as $domain)
                            <option value="{{ $domain->id }}" @if((Auth::user()->default_domain == $domain->id && old('default_domain') == null) || ($domain->id == old('default_domain'))) selected @endif>{{ str_replace(['http://', 'https://'], '', $domain->name) }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('default_domain'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('default_domain') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="i-default-space">{{ __('Space') }} ({{ mb_strtolower(__('Default')) }})</label>
                    </div>
                    <div class="col-auto">
                        @cannot('spaces', ['App\Link', Auth::user()->plan->features->spaces])
                            @if(paymentProcessors())
                                <a href="{{ route('pricing') }}" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'fill-current text-primary width-4 height-4'])</a>
                            @endif
                        @endcannot
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">@include('icons.space', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                    </div>
                    <select name="default_space" id="i-default-space" class="custom-select{{ $errors->has('default_space') ? ' is-invalid' : '' }}" @cannot('spaces', ['App\Link', Auth::user()->plan->features->spaces]) disabled @endcan>
                        <option value="">{{ __('None') }}</option>
                        @foreach($spaces as $space)
                            <option value="{{ $space->id }}" @if((Auth::user()->default_space == $space->id && old('default_space') == null) || ($space->id == old('default_space'))) selected @endif>{{ $space->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('default_space'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('default_space') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="i-default-stats">{{ __('Stats') }} ({{ mb_strtolower(__('Default')) }})</label>
                    </div>
                    <div class="col-auto">
                        @cannot('stats', ['App\Link', Auth::user()->plan->features->stats])
                            @if(paymentProcessors())
                                <a href="{{ route('pricing') }}" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'fill-current text-primary width-4 height-4'])</a>
                            @endif
                        @endcannot
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">@include('icons.stats', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                    </div>
                    <select name="default_stats" id="i-default-stats" class="custom-select{{ $errors->has('default_stats') ? ' is-invalid' : '' }}" @cannot('expiration', ['App\Link', Auth::user()->plan->features->stats]) disabled @endcan>
                        @foreach([0 => __('Public'), 1 => __('Private')] as $key => $value)
                            <option value="{{ $key }}" @if((Auth::user()->default_stats == $key && old('default_stats') == null) || (old('default_stats') !== null && old('default_stats') == $key)) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('default_stats'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('default_stats') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row mt-3">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
                <div class="col-auto">
                </div>
            </div>
        </form>
    </div>
</div>