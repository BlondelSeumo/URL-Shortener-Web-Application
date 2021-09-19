<div class="bg-base-0">
    <div class="container py-5">
        <div class="d-flex">
            <div class="row no-gutters w-100">
                <div class="d-flex col-12 col-md">
                    <div class="flex-shrink-1">
                        <a href="{{ route('account') }}" class="d-block"><img src="{{ gravatar(Auth::user()->email, 128) }}" class="rounded-circle width-16 height-16"></a>
                    </div>
                    <div class="flex-grow-1 d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'mr-3' : 'ml-3') }}">
                        <div>
                            <h4 class="font-weight-medium mb-0">{{ Auth::user()->name }}</h4>

                            <div class="text-muted mt-2">
                                @if(paymentProcessors())
                                    <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'ml-4' : 'mr-4') }}">
                                        <div class="d-flex">
                                            <div class="d-inline-flex align-items-center">
                                                @include('icons.package', ['class' => 'fill-current width-4 height-4'])
                                            </div>

                                            <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">
                                                <a href="{{ route('account.plan') }}" class="text-dark text-decoration-none">{{ Auth::user()->plan->name }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'ml-4' : 'mr-4') }}">
                                        <div class="d-flex">
                                            <div class="d-inline-flex align-items-center">
                                                @include('icons.email', ['class' => 'fill-current width-4 height-4'])
                                            </div>

                                            <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">
                                                {{ Auth::user()->email }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if(paymentProcessors())
                    @if(Auth::user()->planOnDefault())
                        <div class="col-12 col-md-auto d-flex flex-row-reverse align-items-center">
                            <a href="{{ route('pricing') }}" class="btn btn-outline-primary btn-block d-flex justify-content-center align-items-center mt-4 mt-md-0 {{ (__('lang_dir') == 'rtl' ? 'ml-md-3' : 'mr-md-3') }}">@include('icons.package-up', ['class' => 'width-4 height-4 fill-current '.(__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')]){{ __('Upgrade') }}</a>
                        </div>
                    @else
                        <div class="col-12 col-md-auto d-flex flex-row-reverse align-items-center">
                            <a href="{{ route('pricing') }}" class="btn btn-outline-primary btn-block d-flex justify-content-center align-items-center mt-4 mt-md-0 {{ (__('lang_dir') == 'rtl' ? 'ml-md-3' : 'mr-md-3') }}">@include('icons.package', ['class' => 'width-4 height-4 fill-current '.(__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')]){{ __('Plans') }}</a>
                        </div>
                    @endif
                @endif

                <div class="col-12 col-md-auto d-flex flex-row-reverse align-items-center">
                    <a href="{{ route('links') }}" class="btn btn-primary btn-block d-flex justify-content-center align-items-center mt-4 mt-md-0">@include('icons.add', ['class' => 'width-4 height-4 fill-current '.(__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')]){{ __('New link') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>