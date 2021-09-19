<div class="text-center mb-3 mt-5">
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-outline-dark active" id="plan-month">
            <input type="radio" name="options" autocomplete="off" checked>{{ __('Monthly') }}
        </label>
        <label class="btn btn-outline-dark" id="plan-year">
            <input type="radio" name="options" autocomplete="off">{{ __('Yearly') }}
        </label>
    </div>
</div>

<div class="row flex-column-reverse flex-md-row justify-content-center">
    @foreach($plans as $plan)
        <div class="col-12 col-md-4 pt-4">
            <div class="card border-0 shadow-sm rounded h-100 overflow-hidden plan">
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="mt-1 mb-3 text-muted text-uppercase d-inline-block">{{ $plan->name }}</h5>
                    <div class="plan-title-underline" style="background-color: {{ $plan->color }};"></div>
                    <div class="my-4">
                        @if($plan->hasPrice())
                            <div class="plan-preload plan-month d-none d-block">
                                <div class="h1 mb-1">
                                    <span class="font-weight-bold">
                                        {{ formatMoney($plan->amount_month, $plan->currency) }}
                                    </span>
                                    <span class="pricing-plan-price text-muted">
                                        {{ $plan->currency }}
                                    </span>
                                </div>
                                <span class="text-muted text-lowercase">{{ __('Month') }}</span>
                            </div>

                            <div class="plan-year d-none">
                                <div class="h1 mb-1">
                                    <span class="font-weight-bold">
                                        {{ formatMoney($plan->amount_year, $plan->currency) }}
                                    </span>
                                    <span class="pricing-plan-price text-muted">
                                        {{ $plan->currency }}
                                    </span>
                                </div>

                                <span class="text-muted text-lowercase">{{ __('Year') }}</span>

                                @if(($plan->amount_month * 12) > $plan->amount_year)
                                    <span class="badge badge-success">
                                        {{ __(':value% off', ['value' => number_format(((($plan->amount_month*12) - $plan->amount_year)/($plan->amount_month * 12) * 100), 0)]) }}
                                    </span>
                                @endif
                            </div>
                        @else
                            <div class="plan-preload plan-month d-none d-block">
                                <h1 class="mb-1">
                                    <span class="font-weight-bold text-uppercase">
                                        {{ __('Free') }}
                                    </span>
                                </h1>
                            </div>

                            <div class="plan-year d-none">
                                <h1 class="mb-1">
                                    <span class="font-weight-bold text-uppercase">
                                        {{ __('Free') }}
                                    </span>
                                </h1>
                            </div>

                            <div class="plan-month d-none d-block">
                                <span class="text-muted text-lowercase">{{ __('Month') }}</span>
                            </div>

                            <div class="plan-year d-none">
                                <span class="text-muted text-lowercase">{{ __('Year') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="row py-2">
                            <div class="col{{ ($plan->features->links == 0 ? ' text-black-50' : '') }}">
                                {{ __('Links') }}
                            </div>
                            <div class="col-auto d-flex align-items-center font-weight-medium">
                                @if($plan->features->links < 0)
                                    {{ __('Unlimited') }}
                                @elseif($plan->features->links > 0)
                                    {{ number_format($plan->features->links, 0, __('.'), __(',')) }}
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col{{ ($plan->features->spaces == 0 ? ' text-black-50' : '') }}">
                                {{ __('Spaces') }}
                            </div>
                            <div class="col-auto d-flex align-items-center font-weight-medium">
                                @if($plan->features->spaces < 0)
                                    {{ __('Unlimited') }}
                                @elseif($plan->features->spaces > 0)
                                    {{ number_format($plan->features->spaces, 0, __('.'), __(',')) }}
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col d-flex align-items-center{{ ($plan->features->domains == 0 ? ' text-black-50' : '') }}">
                                {{ __('Domains') }}

                                <div class="d-flex align-content-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('Connect your own custom domains to our service.') }}">@include('icons.info', ['class' => 'text-muted width-4 height-4 fill-current'])</div>
                            </div>
                            <div class="col-auto d-flex align-items-center font-weight-medium">
                                @if($plan->features->domains < 0)
                                    {{ __('Unlimited') }}
                                @elseif($plan->features->domains > 0)
                                    {{ number_format($plan->features->domains, 0, __('.'), __(',')) }}
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col d-flex align-items-center{{ ($plan->features->pixels == 0 ? ' text-black-50' : '') }}">
                                {{ __('Pixels') }}

                                <div class="d-flex align-content-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('Reconnect with your visitors trough retargeting pixels.') }}">@include('icons.info', ['class' => 'text-muted width-4 height-4 fill-current'])</div>
                            </div>
                            <div class="col-auto d-flex align-items-center font-weight-medium">
                                @if($plan->features->pixels < 0)
                                    {{ __('Unlimited') }}
                                @elseif($plan->features->pixels > 0)
                                    {{ number_format($plan->features->pixels, 0, __('.'), __(',')) }}
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        @if(count($domains))
                            <div class="row py-2">
                                <div class="col d-flex align-items-center{{ (!$plan->features->global_domains ? ' text-black-50' : '') }}">
                                    {{ __('Additional domains') }}

                                    <div class="d-flex align-content-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('Get free access to additional domains: :domains.',
['domains' => implode(', ', $domains)]
) }}">@include('icons.info', ['class' => 'text-muted width-4 height-4 fill-current'])</div>
                                </div>

                                <div class="col-auto d-flex align-items-center">
                                    @if($plan->features->global_domains)
                                        @include('icons/checkmark', ['class' => 'text-success fill-current width-4 height-4'])
                                    @else
                                        @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="row py-2">
                            <div class="col{{ (!$plan->features->stats ? ' text-black-50' : '') }}">
                                {{ __('Advanced stats') }}
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                @if($plan->features->stats)
                                    @include('icons/checkmark', ['class' => 'text-success fill-current width-4 height-4'])
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col d-flex align-items-center{{ (!$plan->features->targeting ? ' text-black-50' : '') }}">
                                {{ __('Targeting') }}

                                <div class="d-flex align-content-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('Target specific countries, platforms, languages, or evenly distribute traffic among links.') }}">@include('icons.info', ['class' => 'text-muted width-4 height-4 fill-current'])</div>
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                @if($plan->features->targeting)
                                    @include('icons/checkmark', ['class' => 'text-success fill-current width-4 height-4'])
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col d-flex align-items-center{{ ($plan->features->deep_links == 0 ? ' text-black-50' : '') }}">
                                {{ __('Deep links') }}

                                <div class="d-flex align-content-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('Redirect links to pages in your app, and track their performance.') }}">@include('icons.info', ['class' => 'text-muted width-4 height-4 fill-current'])</div>
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                @if($plan->features->deep_links)
                                    @include('icons/checkmark', ['class' => 'text-success fill-current width-4 height-4'])
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col{{ (!$plan->features->password ? ' text-black-50' : '') }}">
                                {{ __('Link password') }}
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                @if($plan->features->password)
                                    @include('icons/checkmark', ['class' => 'text-success fill-current width-4 height-4'])
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col d-flex align-items-center{{ ($plan->features->expiration == 0 ? ' text-black-50' : '') }}">
                                {{ __('Link expiration') }}

                                <div class="d-flex align-content-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('Set your links to expire after a number of clicks, or at a specific date and time.') }}">@include('icons.info', ['class' => 'text-muted width-4 height-4 fill-current'])</div>
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                @if($plan->features->expiration)
                                    @include('icons/checkmark', ['class' => 'text-success fill-current width-4 height-4'])
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col{{ (!$plan->features->disabled ? ' text-black-50' : '') }}">
                                {{ __('Link deactivation') }}
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                @if($plan->features->disabled)
                                    @include('icons/checkmark', ['class' => 'text-success fill-current width-4 height-4'])
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col{{ (!$plan->features->data_export ? ' text-black-50' : '') }}">
                                {{ __('Data export') }}
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                @if($plan->features->data_export)
                                    @include('icons/checkmark', ['class' => 'text-success fill-current width-4 height-4'])
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col{{ (!$plan->features->utm ? ' text-black-50' : '') }}">
                                {{ __('UTM Builder') }}
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                @if($plan->features->utm)
                                    @include('icons/checkmark', ['class' => 'text-success fill-current width-4 height-4'])
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col{{ (!$plan->features->api ? ' text-black-50' : '') }}">
                                {{ __('API access') }}
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                @if($plan->features->api)
                                    @include('icons/checkmark', ['class' => 'text-success fill-current width-4 height-4'])
                                @else
                                    @include('icons/close', ['class' => 'text-black-50 pt-1 fill-current width-4 height-4'])
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="plan-footer d-flex align-items-end mt-auto">
                        @foreach([0 => 1, 1 => 0.65, 2 => 0.3] as $p => $o)
                            <svg style="bottom: {{ $p }}rem; left: 0; opacity: {{ $o }}; color: {{ $plan->color }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 422.7" preserveAspectRatio="none" class="plan-footer w-100 position-absolute z-0"><path fill="currentColor" d="M0,19.55,79.26,37.21C158.51,54.22,317,68,475.54,67.49c158.51.5,317-35.83,475.54-52.84C1109.6-3,1268.11-3,1426.62,5.74c158.52,9.41,317,25.92,475.54,44.08s317,34.68,396.29,44.09l79.25,8.75v317H0Z"/></svg>
                        @endforeach

                        <div class="z-1 w-100">
                            @auth
                                @if($plan->hasPrice())
                                    @if(Auth::user()->plan->id == $plan->id)
                                        <div class="btn btn-light btn-block text-uppercase py-2 disabled">{{ __('Active') }}</div>
                                    @else
                                        <div class="plan-no-animation plan-month d-none d-block">
                                            <a href="{{ route('checkout.index', ['id' => $plan->id, 'interval' => 'month']) }}" class="btn btn-light btn-block text-uppercase py-2">
                                                @if($plan->trial_days > 0 && ! Auth::user()->plan_trial_ends_at)
                                                    {{ __('Free trial') }}
                                                @else
                                                    {{ __('Subscribe') }}
                                                @endif
                                            </a>
                                        </div>
                                        <div class="plan-no-animation plan-year d-none">
                                            <a href="{{ route('checkout.index', ['id' => $plan->id, 'interval' => 'year']) }}" class="btn btn-light btn-block text-uppercase py-2">
                                                @if($plan->trial_days > 0 && ! Auth::user()->plan_trial_ends_at)
                                                    {{ __('Free trial') }}
                                                @else
                                                    {{ __('Subscribe') }}
                                                @endif
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <div class="btn btn-light btn-block text-uppercase py-2 disabled">{{ __('Free') }}</div>
                                @endif
                            @else
                                @if(config('settings.registration'))
                                    <div class="plan-no-animation plan-month d-none d-block">
                                        <a href="{{ route('register', ['plan' => $plan->id, 'interval' => 'month']) }}" class="btn btn-light btn-block text-uppercase py-2">{{ __('Register') }}</a>
                                    </div>
                                    <div class="plan-no-animation plan-year d-none">
                                        <a href="{{ route('register', ['plan' => $plan->id, 'interval' => 'year']) }}" class="btn btn-light btn-block text-uppercase py-2">{{ __('Register') }}</a>
                                    </div>
                                @else
                                    <div class="plan-no-animation plan-month d-none d-block">
                                        <a href="{{ route('login', ['plan' => $plan->id, 'interval' => 'month']) }}" class="btn btn-light btn-block text-uppercase py-2">{{ __('Login') }}</a>
                                    </div>
                                    <div class="plan-no-animation plan-year d-none">
                                        <a href="{{ route('login', ['plan' => $plan->id, 'interval' => 'year']) }}" class="btn btn-light btn-block text-uppercase py-2">{{ __('Login') }}</a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>