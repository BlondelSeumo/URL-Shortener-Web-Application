<div class="nav-item d-flex">
    <a href="#" class="nav-link py-1 d-flex align-items-center text-secondary" id="dark-mode" data-enable="tooltip" title="{{ __('Change theme') }}" data-dark-mode="{{ (config('settings.dark_mode') == 1 ? 1 : 0) }}">
        @include('icons.daynight', ['class' => 'width-4 height-4 fill-current ' . (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])
        <span class="text-muted">{{ config('settings.dark_mode') == 1 ? __('Dark') : __('Light') }}</span>
    </a>
</div>

<script>
    'use strict';

    window.addEventListener('DOMContentLoaded', function () {
        // Change the css file on input checkbox change
        document.querySelector('#dark-mode') && document.querySelector('#dark-mode').addEventListener('click', function(e) {
            e.preventDefault();

            let appCss = document.querySelector('#app-css');

            // Update the CSS source
            appCss.setAttribute('href', '{{ asset('css/app'. (__('lang_dir') == 'rtl' ? '.rtl' : '')) }}' + (this.dataset.darkMode == 0 ? '.dark' : '') + '.css');

            // Update the text
            this.querySelector('span').textContent = (this.dataset.darkMode == 0 ? '{{ __('Dark') }}' : '{{ __('Light') }}');

            // Set the dark mode status
            setCookie('dark_mode', (this.dataset.darkMode == 0 ? 1 : 0), new Date().getTime() + (10 * 365 * 24 * 60 * 60 * 1000), '/');
            this.dataset.darkMode = (this.dataset.darkMode == 0 ? '1' : '0');
        });
    });
</script>