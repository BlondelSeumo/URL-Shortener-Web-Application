@section('menu')
    @php
        /**
         * key => [icon, title, route, [
         *  subKey => [title, route]
         * ]]
         */
        $menu = [
            'dashboard' => ['dashboard', 'Dashboard', 'admin.dashboard'],
            'settings' => ['settings', 'Settings', null, [
                'general' => ['general', 'General', 'admin.general'],
                'appearance' => ['design', 'Appearance', 'admin.appearance'],
                'email' => ['email', 'Email', 'admin.email'],
                'social' => ['share', 'Social', 'admin.social'],
                'registration' => ['register', 'Registration', 'admin.registration'],
                'announcements' => ['campaign', 'Announcements', 'admin.announcements'],
                'payment-processors' => ['processor', 'Payment processors', 'admin.payment_processors'],
                'billing-information' => ['billing', 'Billing information', 'admin.billing_information'],
                'legal' => ['legal', 'Legal', 'admin.legal'],
                'captcha' => ['captcha', 'Captcha', 'admin.captcha'],
                'cronjobs' => ['clock', 'Cron jobs', 'admin.cronjobs'],
                'shortener' => ['link', 'Shortener', 'admin.shortener'],
                'license' => ['key', 'License', 'admin.license']
            ]],
            'business' => ['business', 'Business', null, [
                'payments' => ['card', 'Payments', 'admin.payments'],
                'plans' => ['package', 'Plans', 'admin.plans'],
                'coupons' => ['coupon', 'Coupons', 'admin.coupons'],
                'tax-rates' => ['tax', 'Tax rates', 'admin.tax_rates']
            ]],
            'languages' => ['language', 'Languages', 'admin.languages'],
            'users' => ['users', 'Users', 'admin.users'],
            'pages' => ['pages', 'Pages', 'admin.pages'],
            'links' => ['link', 'Links', 'admin.links'],
            'spaces' => ['space', 'Spaces', 'admin.spaces'],
            'domains' => ['domain', 'Domains', 'admin.domains'],
            'pixels' => ['pixel', 'Pixels', 'admin.pixels'],
        ];
    @endphp

    <div class="nav d-block text-truncate">
        @foreach ($menu as $key => $value)
            <li class="nav-item">
                <a class="nav-link d-flex px-4 @if (request()->segment(2) == $key && isset($value[3]) == false) active @endif" @if(isset($value[3])) data-toggle="collapse" href="#sub-menu-{{ $key }}" role="button" @if (array_key_exists(request()->segment(2), $value[3])) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapse-{{ $key }}" @else href="{{ (Route::has($value[2]) ? route($value[2]) : $value[2]) }}" @endif>
                    <span class="sidebar-icon d-flex align-items-center">@include('icons.' . $value[0], ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')])</span>
                    <span class="flex-grow-1 text-truncate">{{ __($value[1]) }}</span>
                    @if (isset($value[3])) <span class="d-flex align-items-center ml-auto sidebar-expand">@include('icons.expand', ['class' => 'fill-current text-muted width-3 height-3'])</span> @endif
                </a>
            </li>

            @if (isset($value[3]))
                <div class="collapse sub-menu @if (array_key_exists(request()->segment(2), $menu[$key][3])) show @endif" id="sub-menu-{{ $key }}">
                    @foreach ($value[3] as $subKey => $subValue)
                        <a href="{{ (Route::has($subValue[2]) ? route($subValue[2]) : $subValue[2]) }}" class="nav-link px-4 d-flex text-truncate @if (request()->segment(2) == $subKey) active @endif">
                            <span class="sidebar-icon d-flex align-items-center">@include('icons.' . $subValue[0], ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')])</span>
                            <span class="flex-grow-1 text-truncate">{{ __($subValue[1]) }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
@endsection