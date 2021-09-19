@section('site_title', formatTitle([__('Installation'), config('info.software.name')]))

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-5">
        <div class="h-100 d-flex flex-column justify-content-center align-items-center my-6">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="w-100 mx-auto" style="max-width: 8rem;"><circle cx="100" cy="100" r="100" style="fill:#6c63ff;opacity:0.1"/><path d="M102.09,117.09l12.68-12.68a2.27,2.27,0,0,0-1.59-3.86h-8.13V64.14a4.55,4.55,0,0,0-9.1,0V100.5H87.82a2.25,2.25,0,0,0-1.59,3.86l12.68,12.69A2.25,2.25,0,0,0,102.09,117.09Zm39.32-57.5H118.64a4.5,4.5,0,0,0,0,9h18.22a4.57,4.57,0,0,1,4.55,4.55v54.68a4.56,4.56,0,0,1-4.55,4.54H64.14a4.56,4.56,0,0,1-4.55-4.54V73.18a4.56,4.56,0,0,1,4.55-4.54H82.36a4.53,4.53,0,0,0,0-9H59.59a9.12,9.12,0,0,0-9.09,9.09v63.64a9.12,9.12,0,0,0,9.09,9.09h81.82a9.12,9.12,0,0,0,9.09-9.09V68.68A9.12,9.12,0,0,0,141.41,59.59Z" style="fill:#6c63ff"/><circle cx="150" cy="141" r="24.5" style="fill:#4daa4d"/><polygon points="146.06 153.49 134.38 141.81 137.96 138.23 146.06 146.32 161.2 131.18 164.78 134.77 146.06 153.49" style="fill:#fff"/></svg>

            <div>
                <h5 class="mt-4 text-center">{{ __('Installed') }}</h5>
                <p class="text-center text-muted mb-0">{!! __(':name has been installed.', ['name' => '<span class="font-weight-medium">'.config('info.software.name').'</span>']) !!}</p>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('home') }}" class="btn btn-block btn-primary d-inline-flex align-items-center mt-3 py-2">
    <span class="d-inline-flex align-items-center mx-auto">
        {{ __('Start') }} @include((__('lang_dir') == 'rtl' ? 'icons.chevron-left' : 'icons.chevron-right'), ['class' => 'width-3 height-3 fill-current '.(__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2')])
    </span>
</a>