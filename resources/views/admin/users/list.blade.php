@section('site_title', formatTitle([__('Users'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('Users')],
]])

<div class="d-flex">
    <div class="flex-grow-1">
        <h2 class="mb-3 d-inline-block">{{ __('Users') }}</h2>
    </div>
    <div>
        <a href="{{ route('admin.users.new') }}" class="btn btn-primary mb-3">{{ __('New') }}</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('Users') }}</div></div>
            <div class="col-auto">
                <form method="GET" action="{{ route('admin.users') }}">
                    <div class="input-group input-group-sm">
                        <input class="form-control" name="search" placeholder="{{ __('Search') }}" value="{{ app('request')->input('search') }}">
                        <div class="input-group-append">
                            <button type="button" class="btn {{ request()->input('search') || request()->input('role') || request()->input('by') || request()->input('sort') ? 'btn-primary' : 'btn-outline-primary' }} d-flex align-items-center dropdown-toggle dropdown-toggle-split reset-after" data-enable="tooltip" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.filter', ['class' => 'fill-current width-4 height-4'])&#8203;</button>
                            <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow width-64" id="search-filters">
                                <div class="dropdown-header py-1">
                                    <div class="row">
                                        <div class="col"><div class="font-weight-medium m-0 text-dark">{{ __('Filters') }}</div></div>
                                        <div class="col-auto">
                                            @if(request()->input('search') || request()->input('role') || request()->input('by') || request()->input('sort'))
                                                <a href="{{ route('admin.users') }}" class="text-secondary">{{ __('Reset') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <div class="form-group px-4">
                                    <label for="i-role" class="small">{{ __('Role') }}</label>
                                    <select name="role" id="i-role" class="custom-select custom-select-sm">
                                        <option value="">{{ __('All') }}</option>
                                        @foreach([0 => __('User'), 1 => __('Admin')] as $key => $value)
                                            <option value="{{ $key }}" @if(request()->input('role') == $key && request()->input('role') !== null) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group px-4">
                                    <label for="i-by" class="small">{{ __('Search by') }}</label>
                                    <select name="by" id="i-by" class="custom-select custom-select-sm">
                                        @foreach(['name' => __('Name'), 'email' => __('Email')] as $key => $value)
                                            <option value="{{ $key }}" @if(request()->input('by') == $key || !request()->input('by') && $key == 'name') selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group px-4">
                                    <label for="i-sort" class="small">{{ __('Sort') }}</label>
                                    <select name="sort" id="i-sort" class="custom-select custom-select-sm">
                                        @foreach(['desc' => __('Descending'), 'asc' => __('Ascending')] as $key => $value)
                                            <option value="{{ $key }}" @if(request()->input('sort') == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group px-4 mb-2">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">{{ __('Search') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        @if(count($users) == 0)
            {{ __('No results found.') }}
        @else
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item px-0 text-muted">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="row">
                                <div class="col-12 col-lg-5">{{ __('Name') }}</div>
                                <div class="col-12 col-lg-5">{{ __('Email') }}</div>
                                <div class="col-12 col-lg-2">{{ __('Status') }}</div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="btn btn-outline-primary btn-sm invisible">{{ __('Edit') }}</div>
                        </div>
                    </div>
                </div>
                @foreach($users as $user)
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col text-truncate">
                                <div class="row text-truncate">
                                    <div class="col-12 col-lg-5 d-flex align-items-center text-truncate">
                                        <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                            <img src="{{ gravatar($user->email, 48) }}" class="rounded-circle width-6 height-6">
                                        </div>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-truncate">{{ $user->name }}</a>
                                    </div>
                                    <div class="col-12 col-lg-5 text-truncate">
                                        {{ $user->email }}
                                    </div>
                                    <div class="col-12 col-lg-2 text-truncate d-flex align-items-center">
                                        @if($user->trashed())
                                            <span class="text-truncate badge badge-danger">{{ __('Disabled') }}</span>
                                        @elseif(!$user->email_verified_at)
                                            <span class="text-truncate badge badge-secondary">{{ __('Pending') }}</span>
                                        @else
                                            <span class="text-truncate badge badge-success">{{ __('Active') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm">{{ __('Edit') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-3 align-items-center">
                    <div class="row">
                        <div class="col">
                            <div class="mt-2 mb-3">{{ __('Showing :from-:to of :total', ['from' => $users->firstItem(), 'to' => $users->lastItem(), 'total' => $users->total()]) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            {{ $users->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>