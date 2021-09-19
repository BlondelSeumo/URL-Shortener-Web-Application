@include('shared.toasts.link')

<div class="card border-0 shadow-sm mt-3">
    <div class="card-body">
        <form action="{{ route('links.new') }}" method="post" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-row single-link d-none{{ (old('multi_link') == 0 || old('multi_link') == null) && count(request()->session()->get('toast')) <= 1 ? ' d-flex' : '' }}">
                        <div class="col-12 col-md">
                            <div>
                                <div class="input-group input-group-lg">
                                    <input type="text" dir="ltr" name="url" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }} font-size-lg" autocapitalize="none" spellcheck="false" id="i-url" value="{{ old('url') }}" placeholder="{{ __('Type or paste a link') }}" autofocus>

                                    <div class="input-group-append" data-enable="tooltip" title="{{ __('UTM Builder') }}">
                                        <a href="#" class="btn text-secondary bg-transparent input-group-text d-flex align-items-center" data-toggle="modal" data-target="#utm-modal" id="utm-builder">
                                            @include('icons.tag', ['class' => 'fill-current width-4 height-4'])
                                        </a>
                                    </div>

                                    <div class="input-group-append">
                                        <a href="#" class="btn text-secondary bg-transparent input-group-text d-flex align-items-center" data-toggle="collapse" data-target="#advanced-options" aria-expanded="false">@include('icons.settings', ['class' => 'fill-current width-4 height-4']) <span class="d-none d-md-block small {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ __('Advanced') }}</span></a>
                                    </div>
                                </div>
                                @if ($errors->has('url'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-auto">
                            <button class="btn btn-primary btn-lg btn-block font-size-lg mt-3 mt-md-0" type="submit">{{ __('Shorten') }}</button>
                        </div>
                    </div>

                    <div class="form-row multi-link d-none {{ old('multi_link') || count(request()->session()->get('toast')) > 1 ? ' d-flex' : '' }}">
                        <div class="col-12">
                            <textarea class="form-control form-control-lg font-size-lg {{ $errors->has('urls') ? ' is-invalid' : '' }}" name="urls" id="i-urls" autocapitalize="none" spellcheck="false" rows="3" placeholder="{{ __('Shorten up to :count links at once.', ['count' => 10]) }} {{ __('One per line.') }}" dir="ltr">{{ old('urls') }}</textarea>
                            @if ($errors->has('urls'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('urls') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12 collapse{{ ($errors->has('alias') || $errors->has('domain') || $errors->has('space') || $errors->has('expiration_url') || $errors->has('expiration_clicks') || $errors->has('password') || $errors->has('expiration_date') || $errors->has('expiration_time') || $errors->has('privacy') || $errors->has('privacy_password') || $errors->has('disabled') || $errors->has('country.*.key') || $errors->has('country.*.value') || $errors->has('platform.*.key') || $errors->has('platform.*.value') || $errors->has('language.*.key') || $errors->has('language.*.value') || $errors->has('rotation.*.value')) || ($errors->has('urls') || $errors->has('domain') || $errors->has('pixels') || $errors->has('space')) || count(request()->session()->get('toast')) > 1 ? ' show' : '' }}" id="advanced-options">
                    <div class="row mt-3">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="i-domain-new">{{ __('Domain') }}</label>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">@include('icons.domain', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                    </div>
                                    <select name="domain" id="i-domain-new" class="custom-select{{ $errors->has('domain') ? ' is-invalid' : '' }}">
                                        <option value="">{{ __('None') }}</option>
                                        @foreach($domains as $domain)
                                            <option value="{{ $domain->id }}" @if(old('domain') == $domain->id) selected @elseif(Auth::user()->default_domain == $domain->id && old('domain') == null) selected @endif>{{ str_replace(['http://', 'https://'], '', $domain->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('domain'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('domain') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="i-alias">{{ __('Alias') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">@include('icons.alias', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                    </div>
                                    <input type="text" name="alias" class="form-control{{ $errors->has('alias') ? ' is-invalid' : '' }}" autocapitalize="none" spellcheck="false" id="i-alias" value="{{ old('alias') }}" {{ old('multi_link') == 0 && count(request()->session()->get('toast')) <= 1 ? '' : ' disabled' }}>
                                </div>
                                @if ($errors->has('alias'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('alias') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="i-space-new">{{ __('Space') }}</label>
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
                                    <select name="space" id="i-space-new" class="custom-select{{ $errors->has('space') ? ' is-invalid' : '' }}" @cannot('spaces', ['App\Link', Auth::user()->plan->features->spaces]) disabled @endcannot>
                                        <option value="">{{ __('None') }}</option>
                                        @foreach($spaces as $space)
                                            <option value="{{ $space->id }}" @if(old('space') == $space->id) selected @elseif(Auth::user()->default_space == $space->id) selected @endif>{{ $space->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('space'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('space') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="i-password">{{ __('Password') }}</label>
                                    </div>
                                    <div class="col-auto">
                                        @cannot('password', ['App\Link', Auth::user()->plan->features->password])
                                            @if(paymentProcessors())
                                                <a href="{{ route('pricing') }}" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'fill-current text-primary width-4 height-4'])</a>
                                            @endif
                                        @endcannot
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text cursor-pointer" data-enable="tooltip" data-title="{{ __('Show password') }}" data-password="i-password" data-password-show="{{ __('Show password') }}" data-password-hide="{{ __('Hide password') }}">@include('icons.security', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                    </div>
                                    <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="i-password" value="{{ old('password') }}" autocomplete="new-password" @cannot('password', ['App\Link', Auth::user()->plan->features->password]) disabled @endcan>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="i-expiration-date">{{ __('Expiration date') }}</label>
                                    </div>
                                    <div class="col-auto">
                                        @cannot('expiration', ['App\Link', Auth::user()->plan->features->expiration])
                                            @if(paymentProcessors())
                                                <a href="{{ route('pricing') }}" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'fill-current text-primary width-4 height-4'])</a>
                                            @endif
                                        @endcannot
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">@include('icons.calendar', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                    </div>
                                    <input type="date" name="expiration_date" class="form-control{{ $errors->has('expiration_date') ? ' is-invalid' : '' }}" id="i-expiration-date" placeholder="YYYY-MM-DD" value="{{ old('expiration_date') }}" @cannot('expiration', ['App\Link', Auth::user()->plan->features->expiration]) disabled @endcannot>
                                    <input type="time" name="expiration_time" class="form-control{{ $errors->has('expiration_time') ? ' is-invalid' : '' }}" placeholder="HH:MM" value="{{ old('expiration_time') }}" @cannot('expiration', ['App\Link', Auth::user()->plan->features->expiration]) disabled @endcannot>
                                    <div class="input-group-append">
                                        <div class="input-group-text">@include('icons.expire', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col">
                                        @if ($errors->has('expiration_date'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('expiration_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        @if ($errors->has('expiration_time'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('expiration_time') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <div class="row no-gutters">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col"><label for="i-expiration-url">{{ __('Expiration link') }}</label></div>
                                            <div class="col-auto">
                                                @cannot('expiration', ['App\Link', Auth::user()->plan->features->expiration])
                                                    @if(paymentProcessors())
                                                        <a href="{{ route('pricing') }}" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'fill-current text-primary width-4 height-4'])</a>
                                                    @endif
                                                @endcannot
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 {{ (__('lang_dir') == 'rtl' ? 'text-left' : 'text-right') }}">
                                        <label for="i-expiration-clicks">{{ __('Clicks') }}</label>
                                        @cannot('expiration', ['App\Link', Auth::user()->plan->features->expiration])
                                            @if(paymentProcessors())
                                                <a href="{{ route('pricing') }}" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'fill-current text-primary width-4 height-4'])</a>
                                            @endif
                                        @endcannot
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">@include('icons.link', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                    </div>
                                    <input type="text" dir="ltr" name="expiration_url" id="i-expiration-url" class="form-control{{ $errors->has('expiration_url') ? ' is-invalid' : '' }}" autocapitalize="none" spellcheck="false" value="{{ old('expiration_url') }}" @cannot('expiration', ['App\Link', Auth::user()->plan->features->expiration]) disabled @endcannot>
                                    <input type="number" name="expiration_clicks" id="i-expiration-clicks" class="form-control {{ $errors->has('expiration_clicks') ? ' is-invalid' : '' }}" autocapitalize="none" spellcheck="false" value="{{ old('expiration_clicks') }}" @cannot('expiration', ['App\Link', Auth::user()->plan->features->expiration]) disabled @endcannot>
                                    <div class="input-group-append">
                                        <div class="input-group-text">@include('icons.mouse', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-6">
                                        @if ($errors->has('expiration_url'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('expiration_url') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        @if ($errors->has('expiration_clicks'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('expiration_clicks') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <div class="row no-gutters">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col"><label for="i-privacy">{{ __('Stats') }}</label></div>
                                            <div class="col-auto">
                                                @cannot('stats', ['App\Link', Auth::user()->plan->features->stats])
                                                    @if(paymentProcessors())
                                                        <a href="{{ route('pricing') }}" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'fill-current text-primary width-4 height-4'])</a>
                                                    @endif
                                                @endcannot
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 {{ (__('lang_dir') == 'rtl' ? 'text-left' : 'text-right') }}">
                                        <label for="i-privacy-password">{{ __('Password') }}</label>
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
                                    <select name="privacy" id="i-privacy" class="custom-select{{ $errors->has('privacy') ? ' is-invalid' : '' }}" @cannot('stats', ['App\Link', Auth::user()->plan->features->stats]) disabled @endcannot>
                                        @foreach([1 => __('Private'), 0 => __('Public'), 2 => __('Password')] as $key => $value)
                                            <option value="{{ $key }}" @if (old('privacy') !== null && old('privacy') == $key) selected @elseif(Auth::user()->default_stats == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <input type="password" name="privacy_password" class="form-control{{ $errors->has('privacy_password') ? ' is-invalid' : '' }}" id="i-privacy-password" value="{{ old('privacy_password') }}" autocomplete="new-password">
                                    <div class="input-group-append">
                                        <div class="input-group-text cursor-pointer" data-enable="tooltip" data-title="{{ __('Show password') }}" data-password="i-privacy-password" data-password-show="{{ __('Show password') }}" data-password-hide="{{ __('Hide password') }}">@include('icons.security', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-6">
                                        @if ($errors->has('privacy'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('privacy') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        @if ($errors->has('privacy_password'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('privacy_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="i-disabled">{{ __('Disabled') }}</label>
                                    </div>
                                    <div class="col-auto">
                                        @cannot('disabled', ['App\Link', Auth::user()->plan->features->disabled])
                                            @if(paymentProcessors())
                                                <a href="{{ route('pricing') }}" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'fill-current text-primary width-4 height-4'])</a>
                                            @endif
                                        @endcannot
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">@include('icons.block', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                    </div>
                                    <select name="disabled" id="i-disabled" class="custom-select{{ $errors->has('disabled') ? ' is-invalid' : '' }}" @cannot('disabled', ['App\Link', Auth::user()->plan->features->disabled]) disabled @endcannot>
                                        @foreach([0 => __('No'), 1 => __('Yes')] as $key => $value)
                                            <option value="{{ $key }}" @if (old('disabled') !== null && old('disabled') == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('disabled'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('disabled') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="i-pixels">{{ __('Pixels') }}</label>
                                    </div>
                                    <div class="col-auto">
                                        @cannot('pixels', ['App\Link', Auth::user()->plan->features->pixels])
                                            @if(paymentProcessors())
                                                <a href="{{ route('pricing') }}" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'fill-current text-primary width-4 height-4'])</a>
                                            @endif
                                        @endcannot
                                    </div>
                                </div>

                                <input type="hidden" name="pixels[]" value="">
                                <select name="pixels[]" id="i-pixels" class="custom-select{{ $errors->has('pixels') ? ' is-invalid' : '' }}" size="{{ (count($pixels) == 0 ? 1 : 3) }}" @cannot('pixels', ['App\Link', Auth::user()->plan->features->pixels]) disabled @endcannot multiple>
                                    @foreach($pixels as $pixel)
                                        <option value="{{ $pixel->id }}" @if(old('pixels') !== null && in_array($pixel->id, old('pixels'))) selected @endif>{{ $pixel->name }} ({{ config('pixels')[$pixel->type]['name'] }})</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('pixels'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('pixels') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <label>{{ __('Targeting') }}</label>

                            <div class="mb-3">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @foreach([  ['title' => __('None'), 'value' => 0, 'name' => '', 'input' => 'empty'],
                                                ['title' => __('Country'), 'value' => 1, 'name' => 'flag', 'input' => 'country'],
                                                ['title' => __('Platform'), 'value' => 2, 'name' => 'platforms', 'input' => 'platform'],
                                                ['title' => __('Language'), 'value' => 3, 'name' => 'language', 'input' => 'language'],
                                                ['title' => __('Rotation'), 'value' => 4, 'name' => 'rotation', 'input' => 'rotation']
                                                ] as $targetButton)
                                        <label class="btn btn-outline-{{ ($errors->has($targetButton['input'].'.*.key') || $errors->has($targetButton['input'].'.*.value') ? 'danger' : 'secondary') }} d-flex flex-fill align-items-center{{ old('target_type') == $targetButton['value'] ? ' active' : '' }}">
                                            <input type="radio" name="target_type" value="{{ $targetButton['value'] }}" data-target="#{{ $targetButton['input'] }}-container"{{ old('target_type') == $targetButton['value'] ? ' checked' : '' }}>
                                                @if($targetButton['name'])
                                                    @include('icons.'.$targetButton['name'], ['class' => 'width-4 height-4 fill-current'])
                                                @endif
                                            <span class="d-md-inline-block {{ ($targetButton['value'] ? (__('lang_dir') == 'rtl' ? 'd-none mr-2' : 'd-none ml-2') : '') }}">&#8203;{{ $targetButton['title'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tab-content">
                                <div id="empty-container" class="tab-pane fade{{ old('target_type') == 0 ? ' show active' : '' }}"></div>

                                <div id="country-container" class="tab-pane fade{{ old('target_type') == 1 ? ' show active' : '' }}">
                                    <div class="input-content">
                                        <div class="row d-none input-template">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">@include('icons.flag', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                        </div>
                                                        <select data-input="key" class="custom-select" disabled>
                                                            <option value="" selected>{{ __('Country') }}</option>
                                                            @foreach(config('countries') as $key => $value)
                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">@include('icons.link', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                                </div>
                                                                <input type="text" data-input="value" class="form-control" autocapitalize="none" spellcheck="false" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-auto form-group d-flex align-items-start">
                                                        <button type="button" class="btn btn-outline-danger d-flex align-items-center input-delete">@include('icons.delete', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if(old('country'))
                                            @foreach(old('country') as $id => $country)
                                                <div class="row mb-md-0">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">@include('icons.flag', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                                </div>
                                                                <select name="country[{{ $id }}][key]" data-input="key" class="custom-select{{ $errors->has('country.'.$id.'.key') ? ' is-invalid' : '' }}">
                                                                    <option value="">{{ __('Country') }}</option>
                                                                    @foreach(config('countries') as $key => $value)
                                                                        <option value="{{ $key }}" @if($country['key'] == $key) selected @endif>{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @if ($errors->has('country.'.$id.'.key'))
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $errors->first('country.'.$id.'.key') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">@include('icons.link', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                                        </div>
                                                                        <input type="text" name="country[{{ $id }}][value]" data-input="value" class="form-control{{ $errors->has('country.'.$id.'.value') ? ' is-invalid' : '' }}" autocapitalize="none" spellcheck="false" value="{{ $country['value'] }}">
                                                                    </div>
                                                                    @if ($errors->has('country.'.$id.'.value'))
                                                                        <span class="invalid-feedback d-block" role="alert">
                                                                            <strong>{{ $errors->first('country.'.$id.'.value') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-auto form-group d-flex align-items-start">
                                                                <button type="button" class="btn btn-outline-danger d-flex align-items-center input-delete">@include('icons.delete', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    @can('targeting', ['App\Link', Auth::user()->plan->features->targeting])
                                        <button type="button" class="btn btn-outline-secondary input-add d-inline-flex align-items-center">@include('icons.add', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                    @else
                                        @if(paymentProcessors())
                                            <a href="{{ route('pricing') }}" class="btn btn-outline-secondary d-inline-flex align-items-center" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'width-4 height-4 fill-current'])&#8203;</a>
                                        @endif
                                    @endcan
                                </div>

                                <div id="platform-container" class="tab-pane fade{{ old('target_type') == 2 ? ' show active' : '' }}">
                                    <div class="input-content">
                                        <div class="row d-none input-template">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">@include('icons.platforms', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                        </div>
                                                        <select data-input="key" class="custom-select" disabled>
                                                            <option value="" selected>{{ __('Platform') }}</option>
                                                            @foreach(config('platforms') as $platform)
                                                                <option value="{{ $platform }}">{{ $platform }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">@include('icons.link', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                                </div>
                                                                <input type="text" data-input="value" class="form-control" autocapitalize="none" spellcheck="false" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-auto form-group d-flex align-items-start">
                                                        <button type="button" class="btn btn-outline-danger d-flex align-items-center input-delete">@include('icons.delete', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if(old('platform'))
                                            @foreach(old('platform') as $id => $platform)
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">@include('icons.platforms', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                                </div>
                                                                <select name="platform[{{ $id }}][key]" data-input="key" class="custom-select{{ $errors->has('platform.'.$id.'.key') ? ' is-invalid' : '' }}">
                                                                    <option value="">{{ __('Platform') }}</option>
                                                                    @foreach(config('platforms') as $value)
                                                                        <option value="{{ $value }}" @if($platform['key'] == $value) selected @endif>{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @if ($errors->has('platform.'.$id.'.key'))
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $errors->first('platform.'.$id.'.key') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">@include('icons.link', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                                        </div>
                                                                        <input type="text" name="platform[{{ $id }}][value]" data-input="value" class="form-control{{ $errors->has('platform.'.$id.'.value') ? ' is-invalid' : '' }}" autocapitalize="none" spellcheck="false" value="{{ $platform['value'] }}">
                                                                    </div>
                                                                    @if ($errors->has('platform.'.$id.'.value'))
                                                                        <span class="invalid-feedback d-block" role="alert">
                                                                            <strong>{{ $errors->first('platform.'.$id.'.value') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-auto form-group d-flex align-items-start">
                                                                <button type="button" class="btn btn-outline-danger d-flex align-items-center input-delete">@include('icons.delete', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    @can('targeting', ['App\Link', Auth::user()->plan->features->targeting])
                                        <button type="button" class="btn btn-outline-secondary input-add d-inline-flex align-items-center">@include('icons.add', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                    @else
                                        @if(paymentProcessors())
                                            <a href="{{ route('pricing') }}" class="btn btn-outline-secondary d-inline-flex align-items-center" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'width-4 height-4 fill-current'])&#8203;</a>
                                        @endif
                                    @endcan
                                </div>

                                <div id="language-container" class="tab-pane fade{{ old('target_type') == 3 ? ' show active' : '' }}">
                                    <div class="input-content">
                                        <div class="row d-none input-template">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">@include('icons.language', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                        </div>
                                                        <select data-input="key" class="custom-select" disabled>
                                                            <option value="" selected>{{ __('Language') }}</option>
                                                            @foreach(config('languages') as $key => $value)
                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">@include('icons.link', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                                </div>
                                                                <input type="text" data-input="value" class="form-control" autocapitalize="none" spellcheck="false" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-auto form-group d-flex align-items-start">
                                                        <button type="button" class="btn btn-outline-danger d-flex align-items-center input-delete">@include('icons.delete', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if(old('language'))
                                            @foreach(old('language') as $id => $language)
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">@include('icons.languages', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                                </div>
                                                                <select name="language[{{ $id }}][key]" data-input="key" class="custom-select{{ $errors->has('language.'.$id.'.key') ? ' is-invalid' : '' }}">
                                                                    <option value="">{{ __('Language') }}</option>
                                                                    @foreach(config('languages') as $value)
                                                                        <option value="{{ $value }}" @if($language['key'] == $value) selected @endif>{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @if ($errors->has('language.'.$id.'.key'))
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $errors->first('language.'.$id.'.key') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">@include('icons.link', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                                        </div>
                                                                        <input type="text" name="language[{{ $id }}][value]" data-input="value" class="form-control{{ $errors->has('language.'.$id.'.value') ? ' is-invalid' : '' }}" autocapitalize="none" spellcheck="false" value="{{ $language['value'] }}">
                                                                    </div>
                                                                    @if ($errors->has('language.'.$id.'.value'))
                                                                        <span class="invalid-feedback d-block" role="alert">
                                                                            <strong>{{ $errors->first('language.'.$id.'.value') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-auto form-group d-flex align-items-start">
                                                                <button type="button" class="btn btn-outline-danger d-flex align-items-center input-delete">@include('icons.delete', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    @can('targeting', ['App\Link', Auth::user()->plan->features->targeting])
                                        <button type="button" class="btn btn-outline-secondary input-add d-inline-flex align-items-center">@include('icons.add', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                    @else
                                        @if(paymentProcessors())
                                            <a href="{{ route('pricing') }}" class="btn btn-outline-secondary d-inline-flex align-items-center" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'width-4 height-4 fill-current'])&#8203;</a>
                                        @endif
                                    @endcan
                                </div>

                                <div id="rotation-container" class="tab-pane fade{{ old('target_type') == 4 ? ' show active' : '' }}">
                                    <div class="input-content">
                                        <div class="row d-none input-template">
                                            <div class="col-12">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">@include('icons.link', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                                </div>
                                                                <input type="text" data-input="value" class="form-control" autocapitalize="none" spellcheck="false" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-auto form-group d-flex align-items-start">
                                                        <button type="button" class="btn btn-outline-danger d-flex align-items-center input-delete">@include('icons.delete', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if(old('rotation'))
                                            @foreach(old('rotation') as $id => $rotation)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">@include('icons.link', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                                        </div>
                                                                        <input type="text" name="rotation[{{ $id }}][value]" data-input="value" class="form-control{{ $errors->has('rotation.'.$id.'.value') ? ' is-invalid' : '' }}" autocapitalize="none" spellcheck="false" value="{{ $rotation['value'] }}">
                                                                    </div>
                                                                    @if ($errors->has('rotation.'.$id.'.value'))
                                                                        <span class="invalid-feedback d-block" role="alert">
                                                                            <strong>{{ $errors->first('rotation.'.$id.'.value') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-auto form-group d-flex align-items-start">
                                                                <button type="button" class="btn btn-outline-danger d-flex align-items-center input-delete">@include('icons.delete', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    @can('targeting', ['App\Link', Auth::user()->plan->features->targeting])
                                        <button type="button" class="btn btn-outline-secondary input-add d-inline-flex align-items-center">@include('icons.add', ['class' => 'width-4 height-4 fill-current'])&#8203;</button>
                                    @else
                                        @if(paymentProcessors())
                                            <a href="{{ route('pricing') }}" class="btn btn-outline-secondary d-inline-flex align-items-center" data-enable="tooltip" title="{{ __('Unlock feature') }}">@include('icons.unlock', ['class' => 'width-4 height-4 fill-current'])&#8203;</a>
                                        @endif
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-12 col-lg order-2 order-lg-1">
                                    <div class="multi-link d-none{{ old('multi_link') || count(request()->session()->get('toast')) > 1 ? ' d-flex' : '' }}">
                                        <button class="btn btn-primary btn-lg d-flex flex-grow-1 d-lg-inline-flex flex-lg-grow-0 font-size-lg mt-3 mt-lg-0 justify-content-center" type="submit">{{ __('Shorten') }}</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-auto order-1 order-lg-2">
                                    <div class="d-flex flex-wrap">
                                        <a href="{{ route('account.preferences') }}" class="btn btn-outline-secondary d-flex align-items-center{{ (__('lang_dir') == 'rtl' ? ' ml-auto ml-lg-3' : ' mr-auto mr-lg-3') }}" data-enable="tooltip" title="{{ __('Preferences') }}">
                                            @include('icons.preference', ['class' => 'fill-current width-4 height-4'])</span>&#8203;
                                        </a>
                                        <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                                            <label class="btn btn-outline-secondary{{ old('multi_link') == 0 && count(request()->session()->get('toast')) <= 1 ? ' active' : ''}} w-100" id="single-link">
                                                <input type="radio" name="multi_link" id="i-multi-link" value="0"{{ old('multi_link') == 0 && count(request()->session()->get('toast')) <= 1 ? ' checked' : ''}}>{{ __('Single') }}
                                            </label>
                                            <label class="btn btn-outline-secondary{{ old('multi_link') || count(request()->session()->get('toast')) > 1 ? ' active' : ''}} w-100" id="multi-link">
                                                <input type="radio" name="multi_link" value="1"{{ old('multi_link') || count(request()->session()->get('toast')) > 1 ? ' checked' : '' }}>{{ __('Multiple') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('shared.modals.utm')