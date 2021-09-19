@if(isset($admin))
    @section('site_title', formatTitle([__('Edit'), __('User'), config('settings.title')]))
@else
    @section('site_title', formatTitle([__('Profile'), config('settings.title')]))
@endif

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => isset($admin) ? route('admin.dashboard') : route('dashboard'), 'title' => isset($admin) ? __('Admin') : __('Home')],
    ['url' => isset($admin) ? route('admin.users') : route('account'), 'title' => isset($admin) ? __('Users') : __('Account')],
    ['title' => isset($admin) ? __('Edit') : __('Profile')]
]])

<div class="d-flex">
    <h2 class="mb-3 text-break">{{ (isset($admin) ? __('Edit') : __('Profile')) }}</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="font-weight-medium py-1">
            @if(isset($admin))
                {{ __('User') }}
                @if($user->trashed())
                    <span class="badge badge-danger">{{ __('Disabled') }}</span>
                @elseif(!$user->email_verified_at)
                    <span class="badge badge-secondary">{{ __('Pending') }}</span>
                @endif
            @else
                {{ __('Profile') }}
            @endif
        </div>
    </div>

    <div class="card-body">
        @include('shared.message')

        @if($user->getPendingEmail() && isset($admin) == false)
            <div class="alert alert-info d-flex" role="alert">
                <div>
                    <form class="d-inline" method="POST" action="{{ route('account.profile.resend') }}" id="resend-form">
                        @csrf
                        {{ __(':address email address is pending confirmation', ['address' => $user->getPendingEmail()]) }}. {{ __('Didn\'t received the email?') }} <a href="#" class="alert-link font-weight-medium" onclick="event.preventDefault(); document.getElementById('resend-form').submit();">{{ __('Resend') }}</a>
                    </form>
                </div>
                <div class="{{ (__('lang_dir') == 'rtl' ? 'mr-auto' : 'ml-auto') }}">
                    <form class="d-inline" method="POST" action="{{ route('account.profile.cancel') }}" id="cancel-form">
                        @csrf
                        <a href="#" class="alert-link font-weight-medium" onclick="event.preventDefault(); document.getElementById('cancel-form').submit();">{{ __('Cancel') }}</a>
                    </form>
                </div>
            </div>
        @endif

        <form action="{{ (isset($admin) ? route('admin.users.edit', $user->id) : route('account.profile.update')) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-name">{{ __('Name') }}</label>
                <input type="text" name="name" id="i-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') ?? $user->name }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-email">{{ __('Email') }}</label>
                <input type="text" name="email" id="i-email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') ?? $user->email }}">
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-timezone">{{ __('Timezone') }}</label>
                <select name="timezone" id="i-timezone" class="custom-select{{ $errors->has('timezone') ? ' is-invalid' : '' }}">
                    @foreach(timezone_identifiers_list() as $value)
                        <option value="{{ $value }}" @if ($value == $user->timezone) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
                @if ($errors->has('timezone'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('timezone') }}</strong>
                    </span>
                @endif
            </div>

            @if(isset($admin))
                <div class="hr-text"><span class="font-weight-medium text-body">{{ __('Status') }}</span></div>

                <div class="form-group">
                    <label for="i-email-verified-at">{{ __('Verified') }}</label>
                    <select name="email_verified_at" id="i-email-verified-at" class="custom-select{{ $errors->has('email_verified_at') ? ' is-invalid' : '' }}">
                        <option value="0" @if (empty($user->email_verified_at)) selected @endif>{{ __('No') }}</option>
                        <option value="1" @if ($user->email_verified_at) selected @endif>{{ __('Yes') }}</option>
                    </select>
                    @if ($errors->has('email_verified_at'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email_verified_at') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="i-role">{{ __('Role') }}</label>
                    <select name="role" id="i-role" class="custom-select{{ $errors->has('role') ? ' is-invalid' : '' }}">
                        @foreach([0 => __('User'), 1 => __('Admin')] as $key => $value)
                            <option value="{{ $key }}" @if ($key == $user->role) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('role'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('role') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="hr-text"><span class="font-weight-medium text-body">{{ __('Security') }}</span></div>

                <div class="form-group">
                    <label for="i-password">{{ __('New password') }} <span class="text-muted">({{ mb_strtolower(__('Leave empty if you don\'t want to change it')) }})</span></label>
                    <input id="i-password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="i-password-confirmation">{{ __('Confirm new password') }}</label>
                    <input type="password" name="password_confirmation" id="i-password-confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="hr-text"><span class="font-weight-medium text-body">{{ __('Plan') }}</span></div>

                <div class="form-row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="i-plan-id">{{ __('Name') }}</label>
                            <select id="i-plan-id" name="plan_id" class="custom-select{{ $errors->has('plan_id') ? ' is-invalid' : '' }}">
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" @if($user->plan_id == $plan->id) selected @endif>{{ $plan->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('plan_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('plan_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="i-plan-ends-at">{{ __('Ends at') }}</label>
                            <input type="date" name="plan_ends_at" class="form-control{{ $errors->has('plan_ends_at') ? ' is-invalid' : '' }}" id="i-plan-ends-at" placeholder="YYYY-MM-DD" value="{{ old('plan_ends_at') ?? ($user->plan_ends_at ? $user->plan_ends_at->tz($user->timezone ?? config('app.timezone'))->format('Y-m-d') : '') }}">
                            @if ($errors->has('plan_ends_at'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('plan_ends_at') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="row mt-3">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
                <div class="col-auto">
                    @if(isset($admin))
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('More') }}
                        </button>
                        <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow">
                            @if($user->trashed())
                                <a class="dropdown-item text-success d-flex align-items-center" href="#" data-toggle="modal" data-target="#restore-modal">@include('icons.restore', ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('Restore') }}</a>
                                <div class="dropdown-divider"></div>
                            @else
                                <a class="dropdown-item text-danger d-flex align-items-center" href="#" data-toggle="modal" data-target="#disable-modal">@include('icons.block', ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('Disable') }}</a>
                            @endif
                            <a class="dropdown-item text-danger d-flex align-items-center" href="#" data-toggle="modal" data-target="#delete-modal">@include('icons.delete', ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('Delete') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

@if(isset($admin))
    <div class="row">
        @php
            $menu = [
                ['icon' => 'icons.card', 'route' => 'admin.payments', 'title' => __('Payments'), 'stats' => 'payments'],
                ['icon' => 'icons.link', 'route' => 'admin.links', 'title' => __('Links'), 'stats' => 'links'],
                ['icon' => 'icons.space', 'route' => 'admin.spaces', 'title' => __('Spaces'), 'stats' => 'spaces'],
                ['icon' => 'icons.domain', 'route' => 'admin.domains', 'title' => __('Domains'), 'stats' => 'domains'],
                ['icon' => 'icons.pixel', 'route' => 'admin.pixels', 'title' => __('Pixels'), 'stats' => 'pixels']
            ];
        @endphp

        @foreach($menu as $link)
            <div class="col-12 col-md-6 col-lg-4 mt-3">
                <a href="{{ route($link['route'], ['user' => $user->id]) }}" class="text-decoration-none text-secondary">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            @include($link['icon'], ['class' => 'fill-current width-4 height-4 ' . (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3 ')])
                            <div class="text-truncate">{{ $link['title'] }}</div>
                            @include((__('lang_dir') == 'rtl' ? 'icons.chevron-left' : 'icons.chevron-right'), ['class' => 'width-3 height-3 fill-current mx-2'])
                            <div class="{{ (__('lang_dir') == 'rtl' ? 'mr-auto' : 'ml-auto') }} badge badge-primary">{{ number_format($stats[$link['stats']], 0, __('.'), __(',')) }}</div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h6 class="modal-title" id="delete-modal-label">{{ __('Delete') }}</h6>
                    <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete :name?', ['name' => $user->name]) }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" enctype="multipart/form-data">

                        @csrf

                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="disable-modal" tabindex="-1" role="dialog" aria-labelledby="disable-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h6 class="modal-title" id="disable-modal-label">{{ __('Disable') }}</h6>
                    <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(paymentProcessors())
                        <div class="mb-3">{{ __('Disabling this account will cancel any active subscription.') }}</div>
                    @endif
                    <div>{{ __('Are you sure you want to disable :name?', ['name' => $user->name]) }}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <form action="{{ route('admin.users.disable', $user->id) }}" method="post" enctype="multipart/form-data">

                        @csrf

                        <button type="submit" class="btn btn-danger">{{ __('Disable') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="restore-modal" tabindex="-1" role="dialog" aria-labelledby="restore-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h6 class="modal-title" id="restore-modal-label">{{ __('Restore') }}</h6>
                    <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>{{ __('Are you sure you want to restore :name?', ['name' => $user->name]) }}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <form action="{{ route('admin.users.restore', $user->id) }}" method="post" enctype="multipart/form-data">

                        @csrf

                        <button type="submit" class="btn btn-success">{{ __('Restore') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif