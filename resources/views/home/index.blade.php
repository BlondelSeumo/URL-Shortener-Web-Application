@section('site_title', formatTitle([config('settings.title'), e(config('settings.tagline'))]))

@extends('layouts.app')

@section('content')
    <div class="flex-fill">
    <div class="bg-base-0 position-relative">
        <div class="container position-relative py-5 py-sm-6">
            <div class="row">
                <div class="col-12 py-sm-5">
                    <h1 class="display-4 font-weight-bold text-center">{{ __('Simple, powerful & recognizable links') }}</h1>
                    <h2 class="text-muted font-weight-normal mt-4 font-size-xl text-center">{{ __('Brand, track, and share your short links, engage with your users on a different level.') }}</h2>

                    <div class="row">
                        <div class="col-2 d-none d-lg-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.4 37.4" style="width: 1.4rem; height: 1.4rem; transform: rotate(-17deg); {{ (__('lang_dir') == 'rtl' ? 'left' : 'right') }}: 2rem; top: 4rem; filter: blur(1px);" class="position-absolute"><path d="M26.5,3.1a7.81,7.81,0,0,1,7.8,7.8V26.5A7.64,7.64,0,0,1,32,32a7.45,7.45,0,0,1-5.5,2.3H10.9a7.81,7.81,0,0,1-7.8-7.8V10.9a7.81,7.81,0,0,1,7.8-7.8H26.5m0-3.1H10.9A10.94,10.94,0,0,0,0,10.9V26.5A10.94,10.94,0,0,0,10.9,37.4H26.5A10.94,10.94,0,0,0,37.4,26.5V10.9A10.94,10.94,0,0,0,26.5,0Z" style="fill:#e53c5f"/><path d="M28.8,10.9a2.3,2.3,0,1,1,2.3-2.3h0A2.2,2.2,0,0,1,29,10.9ZM18.7,12.5a6.2,6.2,0,1,1-6.2,6.2h0a6.17,6.17,0,0,1,6.14-6.2h.06m0-3.1a9.4,9.4,0,1,0,9.4,9.4h0A9.45,9.45,0,0,0,18.7,9.4Z" style="fill:#e53c5f"/></svg>

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 37.32" style="width: 1.7rem; height: 1.7rem; transform: rotate(22deg); {{ (__('lang_dir') == 'rtl' ? 'left' : 'right') }}: 6rem; top: 2rem; filter: blur(1px);" class="position-absolute"><path d="M46,4.42a16.91,16.91,0,0,1-5.4,1.5A9.86,9.86,0,0,0,44.8.72a19.29,19.29,0,0,1-6,2.3,9.4,9.4,0,0,0-16.3,6.4,16.35,16.35,0,0,0,.2,2.2A27,27,0,0,1,3.2,1.72a9.41,9.41,0,0,0,3,12.6,8.25,8.25,0,0,1-4.3-1.2v.1a9.51,9.51,0,0,0,7.6,9.3,10.55,10.55,0,0,1-2.5.3,12.09,12.09,0,0,1-1.8-.2,9.35,9.35,0,0,0,8.8,6.5A19.14,19.14,0,0,1,0,33a26.43,26.43,0,0,0,14.44,4.3c17.4,0,26.9-14.4,26.9-26.9V9.22A15.36,15.36,0,0,0,46,4.42Z" style="fill:#55acee"/></svg>

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36.4 36.4" style="width: 1.3rem; height: 1.3rem; transform: rotate(-5deg); {{ (__('lang_dir') == 'rtl' ? 'left' : 'right') }}: 4.5rem; top: 6rem; filter: blur(1px);" class="position-absolute"><path d="M12.6,0H23.8C34,0,36.4,2.4,36.4,12.6V23.8C36.4,34,34,36.4,23.8,36.4H12.6C2.4,36.4,0,34,0,23.8V12.6C0,2.4,2.4,0,12.6,0Z" style="fill:#5181b8;fill-rule:evenodd"/><path d="M29.8,12.5c.2-.6,0-1-.8-1H26.4a1.31,1.31,0,0,0-1.2.8,18.63,18.63,0,0,1-3.3,5.4c-.6.6-.9.8-1.2.8s-.4-.2-.4-.8V12.5c0-.7-.2-1-.8-1H15.3c-.4,0-.7.2-.7.6h0c0,.6,1,.8,1.1,2.6v3.9c0,.9-.2,1-.5,1-.9,0-3.1-3.3-4.4-7.1-.3-.7-.5-1-1.2-1H7c-.8,0-.9.4-.9.8,0,.7.9,4.2,4.2,8.8,2.2,3.2,5.3,4.9,8.1,4.9,1.7,0,1.9-.4,1.9-1V22.6c0-.8.2-.9.7-.9s1.1.2,2.6,1.7c1.8,1.8,2.1,2.6,3.1,2.6h2.7c.8,0,1.1-.4.9-1.1a11.65,11.65,0,0,0-2.2-3.1c-.6-.7-1.5-1.5-1.8-1.9a.91.91,0,0,1,0-1.2C26.24,18.7,29.5,14.1,29.8,12.5Z" style="fill:#fff;fill-rule:evenodd"/></svg>
                        </div>

                        @if(config('settings.short_guest'))
                            <div class="col-12 col-lg-8">
                                <div class="form-group mt-5" id="short-form-container"@if(request()->session()->get('link')) style="display: none;"@endif>
                                    <form action="{{ route('guest') }}" method="post" enctype="multipart/form-data" id="short-form">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-12 col-sm">
                                                <input type="text" dir="ltr" autocomplete="off" autocapitalize="none" spellcheck="false" name="url" class="form-control form-control-lg font-size-lg{{ $errors->has('url') || $errors->has('domain') || $errors->has('g-recaptcha-response') ? ' is-invalid' : '' }}" placeholder="{{ __('Shorten your link') }}" autofocus>
                                                @if ($errors->has('url'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('url') }}</strong>
                                                    </span>
                                                @endif

                                                @if ($errors->has('domain'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('domain') }}</strong>
                                                    </span>
                                                @endif

                                                @if ($errors->has('g-recaptcha-response'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-auto">
                                                @if(config('settings.captcha_shorten'))
                                                    {!! NoCaptcha::displaySubmit('short-form', __('Shorten'), ['data-theme' => (request()->cookie('dark_mode') == 1 ? 'dark' : 'light'), 'data-size' => 'invisible', 'class' => 'btn btn-primary btn-lg btn-block font-size-lg mt-3 mt-sm-0']) !!}

                                                    {!! NoCaptcha::renderJs(__('lang_code')) !!}
                                                @else
                                                    <button class="btn btn-primary btn-lg btn-block font-size-lg mt-3 mt-sm-0" type="submit">{{ __('Shorten') }}</button>
                                                @endif
                                            </div>
                                        </div>

                                        <input type="hidden" name="domain" value="{{ $defaultDomain }}">
                                    </form>
                                </div>

                                @include('home.link')
                            </div>
                        @else
                            <div class="col-12 col-lg-8 d-flex justify-content-center">
                                <div class="form-group mt-5">
                                    @if(config('settings.registration'))
                                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg font-size-lg{{ (__('lang_dir') == 'rtl' ? ' ml-3' : ' mr-3') }}">{{ __('Get started for free') }}</a>
                                    @endif
                                    <a href="#features" class="btn btn-outline-primary btn-lg font-size-lg" data-scroll-to="72">{{ __('Learn more') }}</a>
                                </div>
                            </div>
                        @endif

                        <div class="col-2 d-none d-lg-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.4 37.4" style="width: 1.4rem; height: 1.4rem; transform: rotate(7deg); {{ (__('lang_dir') == 'rtl' ? 'right' : 'left') }}: 2rem; top: 4rem; filter: blur(1px);" class="position-absolute"><path d="M37.4,18.67a18.7,18.7,0,1,0-21.6,18.5V24.07H11v-5.4h4.8v-4.1c0-4.7,2.8-7.3,7.1-7.3a20.41,20.41,0,0,1,4.2.4v4.6H24.74a2.71,2.71,0,0,0-3,2.3v4.1h5.2l-.8,5.4h-4.4v13.1A18.7,18.7,0,0,0,37.4,18.67Z" style="fill:#1977f3"/><path d="M26,24.07l.8-5.4H21.6v-3.5a2.62,2.62,0,0,1,2.32-2.89H27V7.67c-1.4-.2-2.8-.3-4.2-.4-4.3,0-7.1,2.6-7.1,7.3v4.1H10.9v5.4h4.84v13.1a19.45,19.45,0,0,0,5.9,0V24.07Z" style="fill:#fefefe"/></svg>

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 31.23 22" style="width: 1.65rem; height: 1.65rem; transform: rotate(22deg); {{ (__('lang_dir') == 'rtl' ? 'right' : 'left') }}: 6rem; top: 2.5rem; filter: blur(1px);" class="position-absolute"><path d="M30.57,3.44A3.9,3.9,0,0,0,27.81.66C25.38,0,15.61,0,15.61,0S5.85,0,3.41.66A3.92,3.92,0,0,0,.65,3.44,41.27,41.27,0,0,0,0,11a41.27,41.27,0,0,0,.65,7.56,3.92,3.92,0,0,0,2.76,2.78c2.44.66,12.2.66,12.2.66s9.77,0,12.2-.66a3.9,3.9,0,0,0,2.76-2.78A40.66,40.66,0,0,0,31.23,11,40.66,40.66,0,0,0,30.57,3.44Z" style="fill:#e70000"/><polygon points="12.42 15.64 12.42 6.36 20.58 11 12.42 15.64" style="fill:#fefefe"/></svg>

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" style="width: 1.3rem; height: 1.3rem; transform: rotate(-20deg); {{ (__('lang_dir') == 'rtl' ? 'right' : 'left') }}: 5rem; top: 6rem; filter: blur(1px);" class="position-absolute"><circle cx="18" cy="18" r="18" style="fill:#ff4500"/><path d="M30,18a2.63,2.63,0,0,0-2.72-2.53,2.58,2.58,0,0,0-1.72.73A12.83,12.83,0,0,0,18.63,14l1.16-5.61,3.86.81a1.8,1.8,0,0,0,3.58-.39,1.8,1.8,0,0,0-3.35-.71l-4.41-.89a.56.56,0,0,0-.66.43h0l-1.33,6.24a12.83,12.83,0,0,0-7,2.22,2.63,2.63,0,1,0-3.6,3.83,2.31,2.31,0,0,0,.71.47,5.34,5.34,0,0,0,0,.8c0,4,4.69,7.31,10.49,7.31s10.49-3.28,10.49-7.31a5.34,5.34,0,0,0,0-.8A2.62,2.62,0,0,0,30,18ZM12,19.8a1.81,1.81,0,1,1,1.81,1.81A1.81,1.81,0,0,1,12,19.8Zm10.46,4.95A6.9,6.9,0,0,1,18,26.14a6.89,6.89,0,0,1-4.44-1.39.48.48,0,0,1,.68-.68A5.9,5.9,0,0,0,18,25.2a5.9,5.9,0,0,0,3.76-1.1.5.5,0,0,1,.7.72h0v-.07Zm-.32-3.08a1.27,1.27,0,1,1,.07.07h-.08Z" style="fill:#fff"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-base-1" id="features">
        <div class="container py-5 py-md-7">
            <div class="text-center">
                <h3 class="h2 mb-3 font-weight-bold text-center">{{ __('Features') }}</h3>
                <div class="m-auto">
                    <p class="text-muted font-weight-normal font-size-lg">{{ __('Measure traffic, know your audience, stay in control of your links.') }}</p>
                </div>
            </div>

            <div class="row mx-lg-n4">
                <div class="col-12 col-sm-6 col-md-4 pt-3 pr-md-3 pl-md-3 pt-lg-4 pr-lg-4 pl-lg-4 mt-4 feature">
                    <div class="card border-0 shadow-sm h-100 border-lg">
                        <div class="card-body d-flex flex-column rounded-lg p-4">
                            <div class="d-flex width-12 height-12 position-relative align-items-center justify-content-center flex-shrink-0 mb-3">
                                <div class="position-absolute bg-cyan opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                                @include('icons.stats', ['class' => 'fill-current width-6 height-6 text-cyan'])
                            </div>
                            <div class="d-block w-100"><h5 class="mt-1 mb-1 d-inline-block font-weight-bold">{{ __('Statistics') }}</h5></div>
                            <div class="d-block w-100 text-muted">{{ __('Get to know your audience, analyze the performance of your links.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 pt-3 pr-md-3 pl-md-3 pt-lg-4 pr-lg-4 pl-lg-4 mt-4 feature">
                    <div class="card border-0 shadow-sm h-100 border-lg">
                        <div class="card-body d-flex flex-column rounded-lg p-4">
                            <div class="d-flex width-12 height-12 position-relative align-items-center justify-content-center flex-shrink-0 mb-3">
                                <div class="position-absolute bg-blue opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                                @include('icons.pixel', ['class' => 'fill-current width-6 height-6 text-blue'])
                            </div>
                            <div class="d-block w-100"><h5 class="mt-1 mb-1 d-inline-block font-weight-bold">{{ __('Retargeting') }}</h5></div>
                            <div class="d-block w-100 text-muted">{{ __('Retarget your audience by adding tracking pixels to your links.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 pt-3 pr-md-3 pl-md-3 pt-lg-4 pr-lg-4 pl-lg-4 mt-4 feature">
                    <div class="card border-0 shadow-sm h-100 border-lg">
                        <div class="card-body d-flex flex-column rounded-lg p-4">
                            <div class="d-flex width-12 height-12 position-relative align-items-center justify-content-center flex-shrink-0 mb-3">
                                <div class="position-absolute bg-purple opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                                @include('icons.devices', ['class' => 'fill-current width-6 height-6 text-purple'])
                            </div>
                            <div class="d-block w-100"><h5 class="mt-1 mb-1 d-inline-block font-weight-bold">{{ __('Targeting') }}</h5></div>
                            <div class="d-block w-100 text-muted">{{ __('Redirect your users based on the country, platform, or language.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 pt-3 pr-md-3 pl-md-3 pt-lg-4 pr-lg-4 pl-lg-4 mt-4 feature">
                    <div class="card border-0 shadow-sm h-100 border-lg">
                        <div class="card-body d-flex flex-column rounded-lg p-4">
                            <div class="d-flex width-12 height-12 position-relative align-items-center justify-content-center flex-shrink-0 mb-3">
                                <div class="position-absolute bg-magenta opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                                @include('icons.calendar', ['class' => 'fill-current width-6 height-6 text-magenta'])
                            </div>
                            <div class="d-block w-100"><h5 class="mt-1 mb-1 d-inline-block font-weight-bold">{{ __('Campaigns') }}</h5></div>
                            <div class="d-block w-100 text-muted">{{ __('Run time or clicks limited marketing campaigns.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 pt-3 pr-md-3 pl-md-3 pt-lg-4 pr-lg-4 pl-lg-4 mt-4 feature">
                    <div class="card border-0 shadow-sm h-100 border-lg">
                        <div class="card-body d-flex flex-column rounded-lg p-4">
                            <div class="d-flex width-12 height-12 position-relative align-items-center justify-content-center flex-shrink-0 mb-3">
                                <div class="position-absolute bg-pink opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                                @include('icons.security', ['class' => 'fill-current width-6 height-6 text-pink'])
                            </div>
                            <div class="d-block w-100"><h5 class="mt-1 mb-1 d-inline-block font-weight-bold">{{ __('Privacy') }}</h5></div>
                            <div class="d-block w-100 text-muted">{{ __('Secure your links from unwanted visitors with the password option.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 pt-3 pr-md-3 pl-md-3 pt-lg-4 pr-lg-4 pl-lg-4 mt-4 feature">
                    <div class="card border-0 shadow-sm h-100 border-lg">
                        <div class="card-body d-flex flex-column rounded-lg p-4">
                            <div class="d-flex width-12 height-12 position-relative align-items-center justify-content-center flex-shrink-0 mb-3">
                                <div class="position-absolute bg-rose opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                                @include('icons.settings', ['class' => 'fill-current width-6 height-6 text-rose'])
                            </div>
                            <div class="d-block w-100"><h5 class="mt-1 mb-1 d-inline-block font-weight-bold">{{ __('Customizability') }}</h5></div>
                            <div class="d-block w-100 text-muted">{{ __('Customize your links with custom domains and aliases.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-base-0">
        <div class="container py-5 py-md-7 position-relative z-1">
            <div class="row pb-5">
                <div class="col-12 col-lg-6">
                    <h3 class="h2 mb-3 font-weight-bold">{{ __('Empower your links') }}</h3>
                    <div class="m-auto">
                        <p class="text-muted font-weight-normal font-size-lg mb-0">{{ __('Users are aware of the links they\'re clicking, branded links will increase your brand recognition, inspire trust and increase your click-through rate.') }}</p>
                    </div>

                    @php
                        $features2 = [
                            [
                                'icon' => 'domain',
                                'title' => __('Domains'),
                                'color' => 'primary',
                                'description' => __('Brand your links with your own domains and increase your click-through rate with up to 35% more.')
                            ],
                            [
                                'icon' => 'alias',
                                'title' => __('Aliases'),
                                'color' => 'primary',
                                'description' => __('There\'s no need for hard to remember links, personalize your links with easy to remember custom aliases.')
                            ]
                        ];
                    @endphp

                    <div class="row mx-lg-n4">
                        @foreach($features2 as $feature)
                            <div class="col-12 pt-3 pr-md-3 pl-md-3 pt-lg-4 pr-lg-4 pl-lg-4 mt-4 feature">
                                <div class="d-flex flex-row">
                                    <div class="d-flex width-12 height-12 position-relative align-items-center justify-content-center flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                        <div class="position-absolute bg-{{ $feature['color'] }} opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                                        @include('icons.'.$feature['icon'], ['class' => 'fill-current width-6 height-6 text-'.$feature['color']])
                                    </div>
                                    <div class="{{ (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1') }}">
                                        <div class="d-block w-100"><h5 class="mt-0 mb-1 d-inline-block font-weight-bold">{{ $feature['title'] }}</h5></div>
                                        <div class="d-block w-100 text-muted">{{ $feature['description'] }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-lg-6 mt-5 mt-lg-0 position-relative">
                    <div class="row justify-content-end">
                        <div class="col-12 col-lg-11">
                            <div class="position-relative">
                                <div class="position-absolute top-0 right-0 bottom-0 left-0 bg-dark opacity-20 rounded-xl" style="border-radius: 1rem !important;"></div>

                                <div class="card border-0 shadow-lg rounded-xl overflow-hidden cursor-default" style="transform: rotate(-3deg);">
                                    <div class="card-header align-items-center">
                                        <div class="row">
                                            <div class="col"><div class="font-weight-medium py-1">{{ __('Links') }}</div></div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="list-group list-group-flush my-n3">
                                            <div class="list-group-item px-0">
                                                <div class="row align-items-center">
                                                    <div class="col d-flex text-truncate">
                                                        <div class="text-truncate">
                                                            <div class="d-flex align-items-center">
                                                                <img src="https://icons.duckduckgo.com/ip3/apple.com.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                                                <div class="text-truncate">
                                                                    <div class="text-primary text-truncate" dir="ltr">example.com/bqh6e</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="width-4 flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>
                                                                <div class="text-muted text-truncate small">
                                                                    <span class="text-secondary">Apple</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto d-flex">
                                                        <div class="btn btn-sm text-primary d-flex align-items-center cursor-default">
                                                            @include('icons.copy-link', ['class' => 'fill-current width-4 height-4'])&#8203;
                                                        </div>
                                                        <div class="btn text-primary btn-sm d-flex align-items-center cursor-default {{ (__('lang_dir') == 'rtl' ? 'mr-3' : 'ml-3') }}">
                                                            @include('icons.horizontal-menu', ['class' => 'fill-current width-4 height-4'])&#8203;
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item px-0">
                                                <div class="row align-items-center">
                                                    <div class="col d-flex text-truncate">
                                                        <div class="text-truncate">
                                                            <div class="d-flex align-items-center">
                                                                <img src="https://icons.duckduckgo.com/ip3/microsoft.com.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                                                <div class="text-truncate">
                                                                    <div class="text-primary text-truncate" dir="ltr">example.com/qyd8s</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="width-4 flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>
                                                                <div class="text-muted text-truncate small">
                                                                    <span class="text-secondary">Microsoft - Official Home Page</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto d-flex">
                                                        <div class="btn btn-sm text-primary d-flex align-items-center cursor-default">
                                                            @include('icons.copy-link', ['class' => 'fill-current width-4 height-4'])&#8203;
                                                        </div>
                                                        <div class="btn text-primary btn-sm d-flex align-items-center cursor-default {{ (__('lang_dir') == 'rtl' ? 'mr-3' : 'ml-3') }}">
                                                            @include('icons.horizontal-menu', ['class' => 'fill-current width-4 height-4'])&#8203;
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item px-0">
                                                <div class="row align-items-center">
                                                    <div class="col d-flex text-truncate">
                                                        <div class="text-truncate">
                                                            <div class="d-flex align-items-center">
                                                                <img src="https://icons.duckduckgo.com/ip3/youtube.com.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                                                <div class="text-truncate">
                                                                    <div class="text-primary text-truncate" dir="ltr">example.net/b6vxe</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="width-4 flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>
                                                                <div class="text-muted text-truncate small">
                                                                    <span class="text-secondary">YouTube</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto d-flex">
                                                        <div class="btn btn-sm text-primary d-flex align-items-center cursor-default">
                                                            @include('icons.copy-link', ['class' => 'fill-current width-4 height-4'])&#8203;
                                                        </div>
                                                        <div class="btn text-primary btn-sm d-flex align-items-center cursor-default {{ (__('lang_dir') == 'rtl' ? 'mr-3' : 'ml-3') }}">
                                                            @include('icons.horizontal-menu', ['class' => 'fill-current width-4 height-4'])&#8203;
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item px-0">
                                                <div class="row align-items-center">
                                                    <div class="col d-flex text-truncate">
                                                        <div class="text-truncate">
                                                            <div class="d-flex align-items-center">
                                                                <img src="https://icons.duckduckgo.com/ip3/messenger.com.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                                                <div class="text-truncate">
                                                                    <div class="text-primary text-truncate" dir="ltr">example.org/e362o</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="width-4 flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>
                                                                <div class="text-muted text-truncate small">
                                                                    <span class="text-secondary">Messenger</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto d-flex">
                                                        <div class="btn btn-sm text-primary d-flex align-items-center cursor-default">
                                                            @include('icons.copy-link', ['class' => 'fill-current width-4 height-4'])&#8203;
                                                        </div>
                                                        <div class="btn text-primary btn-sm d-flex align-items-center cursor-default {{ (__('lang_dir') == 'rtl' ? 'mr-3' : 'ml-3') }}">
                                                            @include('icons.horizontal-menu', ['class' => 'fill-current width-4 height-4'])&#8203;
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item px-0">
                                                <div class="row align-items-center">
                                                    <div class="col d-flex text-truncate">
                                                        <div class="text-truncate">
                                                            <div class="d-flex align-items-center">
                                                                <img src="https://icons.duckduckgo.com/ip3/yahoo.com.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                                                <div class="text-truncate">
                                                                    <div class="text-primary text-truncate" dir="ltr">example.com/gmyux</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="width-4 flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>
                                                                <div class="text-muted text-truncate small">
                                                                    <span class="text-secondary">Yahoo</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto d-flex">
                                                        <div class="btn btn-sm text-primary d-flex align-items-center cursor-default">
                                                            @include('icons.copy-link', ['class' => 'fill-current width-4 height-4'])&#8203;
                                                        </div>
                                                        <div class="btn text-primary btn-sm d-flex align-items-center cursor-default {{ (__('lang_dir') == 'rtl' ? 'mr-3' : 'ml-3') }}">
                                                            @include('icons.horizontal-menu', ['class' => 'fill-current width-4 height-4'])&#8203;
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
            </div>
        </div>
    </div>

    <div class="bg-base-1">
        <div class="container py-5 py-md-7 position-relative z-1">
            <div class="row pt-5">
                <div class="col-12 col-lg-6 order-1 order-lg-2">
                    <h3 class="h2 mb-3 font-weight-bold">{{ __('Empower yourself') }}</h3>
                    <div class="m-auto">
                        <p class="text-muted font-weight-normal font-size-lg mb-0">
                            {{ __('Get to know your audience with our detailed statistics and better understand the performance of your links, while also being GDPR, CCPA and PECR compliant.') }}
                        </p>
                    </div>

                    @php
                        $features3 = [
                            [
                                'icon' => 'stats',
                                'title' => __('Stats'),
                                'color' => 'primary',
                                'description' => __('Get detailed statistics such as Referrers, Countries, Cities, Browsers, Platforms, Languages and Devices.')
                            ],
                            [
                                'icon' => 'pixel',
                                'title' => __('Retargeting'),
                                'color' => 'primary',
                                'description' => __('Increase your conversion by reaching back your audience with our integration of pixel retargeting.')
                            ]
                        ];
                    @endphp

                    <div class="row mx-lg-n4">
                        @foreach($features3 as $feature)
                            <div class="col-12 pt-3 pr-md-3 pl-md-3 pt-lg-4 pr-lg-4 pl-lg-4 mt-4 feature">
                                <div class="d-flex flex-row">
                                    <div class="d-flex width-12 height-12 position-relative align-items-center justify-content-center flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                        <div class="position-absolute bg-{{ $feature['color'] }} opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                                        @include('icons.'.$feature['icon'], ['class' => 'fill-current width-6 height-6 text-'.$feature['color']])
                                    </div>
                                    <div class="{{ (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1') }}">
                                        <div class="d-block w-100"><h5 class="mt-0 mb-1 d-inline-block font-weight-bold">{{ $feature['title'] }}</h5></div>
                                        <div class="d-block w-100 text-muted">{{ $feature['description'] }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-lg-6 mt-5 mt-lg-0 position-relative order-2 order-lg-1">
                    <div class="row">
                        <div class="col-12 col-lg-11">
                            <div class="position-relative">
                                <div class="position-absolute top-0 right-0 bottom-0 left-0 bg-dark opacity-20 rounded-xl" style="border-radius: 1rem !important;"></div>

                                <div class="card border-0 shadow-lg rounded-xl overflow-hidden cursor-default" style="transform: rotate(-3deg);">
                                    <div class="card-header align-items-center">
                                        <div class="row">
                                            <div class="col"><div class="font-weight-medium py-1">{{ __('Stats') }}</div></div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="list-group list-group-flush my-n3">
                                            <div class="list-group-item px-0 border-0">
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <div class="d-flex text-truncate align-items-center">
                                                            <div class="d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}"><img src="{{ asset('images') }}/icons/countries/us.svg" class="width-4 height-4"></div>
                                                            <div class="text-truncate">
                                                                <span class="text-body">United States</span>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-baseline {{ (__('lang_dir') == 'rtl' ? 'mr-3 text-left' : 'ml-3 text-right') }}">
                                                            <div>
                                                                {{ number_format(12, 0, __('.'), __(',')) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="progress chart-progress w-100">
                                                        <div class="progress-bar rounded" role="progressbar" style="width: 18%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item px-0 border-0">
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <div class="d-flex text-truncate align-items-center">
                                                            <div class="d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}"><img src="{{ asset('images') }}/icons/platforms/windows.svg" class="width-4 height-4"></div>
                                                            <div class="text-truncate">
                                                                Windows
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-baseline {{ (__('lang_dir') == 'rtl' ? 'mr-3 text-left' : 'ml-3 text-right') }}">
                                                            <div>
                                                                {{ number_format(30, 0, __('.'), __(',')) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="progress chart-progress w-100">
                                                        <div class="progress-bar rounded" role="progressbar" style="width: 60%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item px-0 border-0">
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <div class="d-flex text-truncate align-items-center">
                                                            <div class="d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}"><img src="{{ asset('images') }}/icons/browsers/chrome.svg" class="width-4 height-4"></div>
                                                            <div class="text-truncate">
                                                                Chrome
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-baseline {{ (__('lang_dir') == 'rtl' ? 'mr-3 text-left' : 'ml-3 text-right') }}">
                                                            <div>
                                                                {{ number_format(25, 0, __('.'), __(',')) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="progress chart-progress w-100">
                                                        <div class="progress-bar rounded" role="progressbar" style="width: 48%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item px-0 border-0">
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <div class="d-flex text-truncate align-items-center">
                                                            <div class="d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}">
                                                                <img src="https://icons.duckduckgo.com/ip3/www.youtube.com.ico" rel="noreferrer" class="width-4 height-4">
                                                            </div>

                                                            <div class="d-flex text-truncate">
                                                                <div class="text-truncate" dir="ltr">www.youtube.com</div> <span class="text-secondary d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}"><svg xmlns="http://www.w3.org/2000/svg" class="fill-current width-3 height-3" viewBox="0 0 18 18"><path d="M16,16H2V2H9V0H2A2,2,0,0,0,0,2V16a2,2,0,0,0,2,2H16a2,2,0,0,0,2-2V9H16ZM11,0V2h3.59L4.76,11.83l1.41,1.41L16,3.41V7h2V0Z"></path></svg>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-baseline {{ (__('lang_dir') == 'rtl' ? 'mr-3 text-left' : 'ml-3 text-right') }}">
                                                            <div>
                                                                {{ number_format(18, 0, __('.'), __(',')) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="progress chart-progress w-100">
                                                        <div class="progress-bar bg-visitor rounded" role="progressbar" style="width: 22%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item px-0 border-0">
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <div class="d-flex text-truncate align-items-center">
                                                            <div class="d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}"><img src="{{ asset('images') }}/icons/devices/desktop.svg" class="width-4 height-4"></div>
                                                            <div class="text-truncate">
                                                                Desktop
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-baseline {{ (__('lang_dir') == 'rtl' ? 'mr-3 text-left' : 'ml-3 text-right') }}">
                                                            <div>
                                                                {{ number_format(36, 0, __('.'), __(',')) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="progress chart-progress w-100">
                                                        <div class="progress-bar rounded" role="progressbar" style="width: 66%"></div>
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
        </div>
    </div>

    <div class="bg-base-0">
        <div class="container position-relative text-center py-5 py-md-7 d-flex flex-column z-1">
            <h3 class="h2 mb-3 font-weight-bold text-center">{{ __('Integrations') }}</h3>
            <div class="m-auto text-center">
                <p class="text-muted font-weight-normal font-size-lg">{{ __('Easily integrates with your favorite retargeting platforms.') }}</p>
            </div>

            <div class="d-flex flex-wrap justify-content-center justify-content-lg-between mt-4 mx-n3">
                <div class="bg-base-1 d-flex width-20 height-20 position-relative align-items-center justify-content-center flex-shrink-0 border-radius-35 mx-3 mt-3" data-enable="tooltip" title="{{ __('Google Ads') }}">
                    <img src="{{ asset('/images/icons/pixels/' . md5('google-ads')) }}.svg" class="height-8">
                </div>

                <div class="bg-base-1 d-flex width-20 height-20 position-relative align-items-center justify-content-center flex-shrink-0 border-radius-35 mx-3 mt-3" data-enable="tooltip" title="{{ __('Google Analytics') }}">
                    <img src="{{ asset('/images/icons/pixels/' . md5('google-analytics')) }}.svg" class="height-8">
                </div>

                <div class="bg-base-1 d-flex width-20 height-20 position-relative align-items-center justify-content-center flex-shrink-0 border-radius-35 mx-3 mt-3" data-enable="tooltip" title="{{ __('Google Tag Manager') }}">
                    <img src="{{ asset('/images/icons/pixels/' . md5('google-tag-manager')) }}.svg" class="height-8">
                </div>

                <div class="bg-base-1 d-flex width-20 height-20 position-relative align-items-center justify-content-center flex-shrink-0 border-radius-35 mx-3 mt-3" data-enable="tooltip" title="{{ __('Facebook') }}">
                    <img src="{{ asset('/images/icons/pixels/' . md5('facebook')) }}.svg" class="height-8">
                </div>

                <div class="bg-base-1 d-flex width-20 height-20 position-relative align-items-center justify-content-center flex-shrink-0 border-radius-35 mx-3 mt-3" data-enable="tooltip" title="{{ __('Bing') }}">
                    <img src="{{ asset('/images/icons/pixels/' . md5('bing')) }}.svg" class="height-8">
                </div>

                <div class="bg-base-1 d-flex width-20 height-20 position-relative align-items-center justify-content-center flex-shrink-0 border-radius-35 mx-3 mt-3" data-enable="tooltip" title="{{ __('Twitter') }}">
                    <img src="{{ asset('/images/icons/pixels/' . md5('twitter')) }}.svg" class="height-8">
                </div>

                <div class="bg-base-1 d-flex width-20 height-20 position-relative align-items-center justify-content-center flex-shrink-0 border-radius-35 mx-3 mt-3" data-enable="tooltip" title="{{ __('Pinterest') }}">
                    <img src="{{ asset('/images/icons/pixels/' . md5('pinterest')) }}.svg" class="height-8">
                </div>

                <div class="bg-base-1 d-flex width-20 height-20 position-relative align-items-center justify-content-center flex-shrink-0 border-radius-35 mx-3 mt-3" data-enable="tooltip" title="{{ __('LinkedIn') }}">
                    <img src="{{ asset('/images/icons/pixels/' . md5('linkedin')) }}.svg" class="height-8">
                </div>

                <div class="bg-base-1 d-flex width-20 height-20 position-relative align-items-center justify-content-center flex-shrink-0 border-radius-35 mx-3 mt-3" data-enable="tooltip" title="{{ __('Quora') }}">
                    <img src="{{ asset('/images/icons/pixels/' . md5('quora')) }}.svg" class="height-8">
                </div>

                <div class="bg-base-1 d-flex width-20 height-20 position-relative align-items-center justify-content-center flex-shrink-0 border-radius-35 mx-3 mt-3" data-enable="tooltip" title="{{ __('Adroll') }}">
                    <img src="{{ asset('/images/icons/pixels/' . md5('adroll')) }}.svg" class="height-8">
                </div>
            </div>
        </div>
    </div>

    @if(paymentProcessors())
        <div class="bg-base-1">
            <div class="container py-5 py-md-7 position-relative z-1">
                <div class="text-center">
                    <h3 class="h2 mb-3 font-weight-bold text-center">{{ __('Plans') }}</h3>
                    <div class="m-auto">
                        <p class="text-muted font-weight-normal font-size-lg">{{ __('Simple pricing plans for everyone and every budget.') }}</p>
                    </div>
                </div>

                @include('shared.pricing')

                <div class="d-flex justify-content-center">
                    <a href="{{ route('pricing') }}" class="btn btn-outline-primary py-2 mt-5">{{ __('Learn more') }}</a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-base-1">
            <div class="container position-relative text-center py-5 py-md-7 d-flex flex-column z-1">
                <div class="flex-grow-1">
                    <div class="badge badge-pill badge-success mb-3 px-3 py-2">{{ __('Join us') }}</div>
                    <div class="text-center">
                        <h4 class="mb-3 font-weight-bold">{{ __('Ready to get started?') }}</h4>
                        <div class="m-auto">
                            <p class="mb-5 font-weight-normal text-muted font-size-lg">{{ __('Track your visitors without compromising their privacy.') }}</p>
                        </div>
                    </div>
                </div>

                <div><a href="{{ route('register') }}" class="btn btn-primary py-2">{{ __('Get started') }}</a></div>
            </div>
        </div>
    @endif
</div>
@endsection