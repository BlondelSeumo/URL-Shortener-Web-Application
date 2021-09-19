@section('site_title', formatTitle([__('Update'), config('info.software.name')]))

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-5">
        <div class="h-100 d-flex flex-column justify-content-center align-items-center my-6">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="w-100 mx-auto" style="max-width: 8rem;"><circle cx="100" cy="100" r="100" style="fill:#6c63ff;opacity:0.1"/><path d="M150.5,86.6V57.21a2.75,2.75,0,0,0-4.72-2l-9.89,9.89a50,50,0,1,0,14.22,41.56,5.58,5.58,0,0,0-5.56-6.22,5.47,5.47,0,0,0-5.44,4.78,39,39,0,0,1-39.17,34.12c-20.62-.28-38-17.67-38.34-38.34A38.9,38.9,0,0,1,128,73L116.38,84.6a2.79,2.79,0,0,0,2,4.78h29.39A2.75,2.75,0,0,0,150.5,86.6Z" style="fill:#6c63ff"/><circle cx="150" cy="141" r="24.5" style="fill:#4daa4d"/><polygon points="146.06 153.49 134.38 141.81 137.96 138.23 146.06 146.32 161.2 131.18 164.78 134.77 146.06 153.49" style="fill:#fff"/></svg>

            <div>
                <h5 class="mt-4 text-center">{{ __('Update') }}</h5>
                <p class="text-center text-muted mb-0">{!! __(':name has been updated.', ['name' => '<span class="font-weight-medium">'.config('settings.title').'</span>']) !!}</p>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('home') }}" class="btn btn-block btn-primary d-inline-flex align-items-center mt-3 py-2">
    <span class="d-inline-flex align-items-center mx-auto">
        {{ __('Start') }} @include((__('lang_dir') == 'rtl' ? 'icons.chevron-left' : 'icons.chevron-right'), ['class' => 'width-3 height-3 fill-current '.(__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2')])
    </span>
</a>