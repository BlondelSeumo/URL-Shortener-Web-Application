@section('site_title', formatTitle([__('Edit'), __('Domain'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => isset($admin) ? route('admin.dashboard') : route('dashboard'), 'title' => isset($admin) ? __('Admin') : __('Home')],
    ['url' => isset($admin) ? route('admin.domains') : route('domains'), 'title' => __('Domains')],
    ['title' => __('Edit')],
]])

<div class="d-flex">
    <h2 class="mb-3 text-break">{{ __('Edit') }}</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Domain') }}</div>
            </div>
            <div class="col-auto">
                @if(!isset($admin))
                    <a href="{{ route('links', ['domain' => $domain->id]) }}" class="btn btn-outline-primary btn-sm">{{ __('View') }}</a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ isset($admin) ? route('admin.domains.edit', $domain->id) : route('domains.edit', $domain->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-name">{{ __('Domain') }}</label>
                <input type="text" dir="ltr" name="name" class="form-control" id="i-name" value="{{ old('name') ?? $domain->name }}" disabled>
            </div>

            <div class="form-group">
                <label for="i-index-page">{{ __('Custom index') }}</label>
                <input type="text" dir="ltr" name="index_page" id="i-index-page" class="form-control{{ $errors->has('index_page') ? ' is-invalid' : '' }}" value="{{ (old('index_page') ?? $domain->index_page) }}">
                @if ($errors->has('index_page'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('index_page') }}</strong>
                    </span>
                @endif
                <small class="text-muted">{{ __('Add a custom index page.') }}</small>
            </div>

            <div class="form-group">
                <label for="i-not-found-page">{{ __('Custom 404') }}</label>
                <input type="text" dir="ltr" name="not_found_page" id="i-not-found-page" class="form-control{{ $errors->has('not_found_page') ? ' is-invalid' : '' }}" value="{{ (old('not_found_page') ?? $domain->not_found_page) }}">
                @if ($errors->has('not_found_page'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('not_found_page') }}</strong>
                    </span>
                @endif
                <small class="form-text text-muted">{{ __('Add a custom 404 page.') }}</small>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-modal">{{ __('Delete') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@if(isset($admin))
    @if(isset($domain->user))
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header">
                <div class="row"><div class="col"><div class="font-weight-medium py-1">{{ __('User') }}</div></div><div class="col-auto"><a href="{{ route('admin.users.edit', $domain->user->id) }}" class="btn btn-outline-primary btn-sm">{{ __('Edit') }}</a></div></div>
            </div>
            <div class="card-body mb-n3">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="text-muted">{{ __('Name') }}</div>
                        <div>{{ $domain->user->name }}</div>
                    </div>

                    <div class="col-12 col-lg-6 mb-3">
                        <div class="text-muted">{{ __('Email') }}</div>
                        <div>{{ $domain->user->email }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

@if(isset($admin))
    <div class="row">
        @php
            $menu = [
                ['icon' => 'icons.link', 'route' => 'admin.links', 'title' => __('Links'), 'stats' => 'links']
            ];
        @endphp

        @foreach($menu as $link)
            <div class="col-12 col-md-6 col-lg-4 mt-3">
                <a href="{{ route($link['route'], ['domain' => $domain->id]) }}" class="text-decoration-none text-secondary">
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
@endif

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
                <div class="mb-3">{{ __('Deleting this domain is permanent, and will remove all the links associated with it.') }}</div>
                <div>{{ __('Are you sure you want to delete :name?', ['name' => $domain->name]) }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ isset($admin) ? route('admin.domains.destroy', $domain->id) : route('domains.destroy', $domain->id) }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>