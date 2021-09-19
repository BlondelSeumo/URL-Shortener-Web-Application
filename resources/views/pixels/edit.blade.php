@section('site_title', formatTitle([__('Edit'), __('Pixel'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => isset($admin) ? route('admin.dashboard') : route('dashboard'), 'title' => isset($admin) ? __('Admin') : __('Home')],
    ['url' => isset($admin) ? route('admin.pixels') : route('pixels'), 'title' => __('Pixels')],
    ['title' => __('Edit')],
]])

<div class="d-flex">
    <h2 class="mb-3 text-break">{{ __('Edit') }}</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Pixel') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ isset($admin) ? route('admin.pixels.edit', $pixel->id) : route('pixels.edit', $pixel->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            @if(isset($admin))
                <input type="hidden" name="user_id" value="{{ $pixel->user->id }}">
            @endif

            <div class="form-group">
                <label for="i-name">{{ __('Name') }}</label>
                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="i-name" value="{{ old('name') ?? $pixel->name }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-type">{{ __('Type') }}</label>
                <select name="type" id="i-type" class="custom-select{{ $errors->has('type') ? ' is-invalid' : '' }}">
                    @foreach(config('pixels') as $key => $value)
                        <option value="{{ $key }}" @if((old('type') !== null && old('type') == $key) || ($pixel->type == $key && old('type') == null)) selected @endif>{{ $value['name'] }}</option>
                    @endforeach
                </select>
                @if ($errors->has('type'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('type') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-value" class="d-flex align-items-center">{{ __('Value') }} <span class="d-flex align-content-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('The pixel ID value.') }}">@include('icons.info', ['class' => 'text-muted width-4 height-4 fill-current'])</span></label>
                <input type="text" name="value" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" id="i-value" value="{{ old('value') ?? $pixel->value }}">
                @if ($errors->has('value'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('value') }}</strong>
                    </span>
                @endif
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
    @if(isset($pixel->user))
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header">
                <div class="row"><div class="col"><div class="font-weight-medium py-1">{{ __('User') }}</div></div><div class="col-auto"><a href="{{ route('admin.users.edit', $pixel->user->id) }}" class="btn btn-outline-primary btn-sm">{{ __('Edit') }}</a></div></div>
            </div>
            <div class="card-body mb-n3">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="text-muted">{{ __('Name') }}</div>
                        <div>{{ $pixel->user->name }}</div>
                    </div>

                    <div class="col-12 col-lg-6 mb-3">
                        <div class="text-muted">{{ __('Email') }}</div>
                        <div>{{ $pixel->user->email }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        @php
            $menu = [
                ['icon' => 'icons.link', 'route' => 'admin.links', 'title' => __('Links'), 'stats' => 'links']
            ];
        @endphp

        @foreach($menu as $link)
            <div class="col-12 col-md-6 col-lg-4 mt-3">
                <a href="{{ route($link['route'], ['pixel' => $pixel->id]) }}" class="text-decoration-none text-secondary">
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
                <div class="mb-3">{{ __('Deleting this pixel is permanent, and will remove all the links associated with it.') }}</div>
                <div>{{ __('Are you sure you want to delete :name?', ['name' => str_replace(['http://', 'https://'], '', $pixel->name)]) }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ isset($admin) ? route('admin.pixels.destroy', $pixel->id) : route('pixels.destroy', $pixel->id) }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>