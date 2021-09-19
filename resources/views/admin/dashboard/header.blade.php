<div class="bg-base-0">
    <div class="container py-5">
        <div class="d-flex">
            <div class="row no-gutters w-100">
                <div class="d-flex col-12 col-md">
                    <div class="flex-grow-1 d-flex align-items-center">
                        <div>
                            <h2 class="font-weight-medium mb-0">{{ config('settings.title') }}</h2>

                            <div class="text-muted mt-2">
                                <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'ml-4' : 'mr-4') }}">
                                    <div class="d-flex">
                                        <div class="d-inline-flex align-items-center">
                                            @include('icons.info', ['class' => 'fill-current width-4 height-4'])
                                        </div>

                                        <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">
                                            <a href="{{ config('info.software.url') }}/changelog" class="text-dark text-decoration-none" target="_blank">{{ __('Version') }} <span class="badge badge-primary">{{ config('info.software.version') }}</span></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'ml-4' : 'mr-4') }}">
                                    <div class="d-flex">
                                        <div class="d-inline-flex align-items-center">
                                            @include('icons.key', ['class' => 'fill-current width-4 height-4'])
                                        </div>

                                        <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">
                                            <a href="{{ route('admin.license') }}" class="text-dark text-decoration-none">{{ __('License') }} <span class="badge badge-primary">{{ config('settings.license_type') ? 'Extended' : 'Regular' }}</span></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'ml-4' : 'mr-4') }}">
                                    <div class="d-flex">
                                        <div class="d-inline-flex align-items-center">
                                            @include('icons.book', ['class' => 'fill-current width-4 height-4'])
                                        </div>

                                        <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">
                                            <a href="{{ config('info.software.url') }}/documentation" class="text-dark text-decoration-none" target="_blank">{{ __('Documentation') }}</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'ml-4' : 'mr-4') }}">
                                    <div class="d-flex">
                                        <div class="d-inline-flex align-items-center">
                                            @include('icons.star', ['class' => 'fill-current width-4 height-4'])
                                        </div>

                                        <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">
                                            <a href="{{ config('info.software.url') }}" class="text-dark text-decoration-none" target="_blank">{{ config('info.software.name') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-auto d-flex flex-row-reverse align-items-center"></div>
            </div>
        </div>
    </div>
</div>