@section('site_title', formatTitle([__('Cron jobs'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('Cron jobs')],
]])

<h2 class="mb-3 d-inline-block">{{ __('Cron jobs') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('Cron jobs') }}</div></div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <div class="form-group">
            <label for="i-cronjob-cache">{!! __(':name command', ['name' => '<span class="badge badge-primary">cache</span>']) !!}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <code class="input-group-text" id="basic-addon1">0 6 * * 0</code>
                </div>
                <input type="text" dir="ltr" name="cronjob_cache" id="i-cronjob-cache" class="form-control" value="wget {{ route('cronjobs.cache', ['key' => config('settings.cronjob_key')]) }} >/dev/null 2>&1" readonly>
                <div class="input-group-append">
                    <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-cronjob-cache">{{ __('Copy') }}</div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#regenerate-modal">{{ __('Regenerate') }}</button>
    </div>
</div>

<div class="card border-0 shadow-sm mt-3">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('History') }}</div></div>
            <div class="col-auto">
                <form method="GET" action="{{ route('admin.cronjobs') }}">
                    <div class="input-group input-group-sm">
                        <input class="form-control" name="search" placeholder="{{ __('Search') }}" value="{{ app('request')->input('search') }}">
                        <div class="input-group-append">
                            <button type="button" class="btn {{ request()->input('search') || request()->input('sort') ? 'btn-primary' : 'btn-outline-primary' }} d-flex align-items-center dropdown-toggle dropdown-toggle-split reset-after" data-enable="tooltip" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.filter', ['class' => 'fill-current width-4 height-4'])&#8203;</button>
                            <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow width-64" id="search-filters">
                                <div class="dropdown-header py-1">
                                    <div class="row">
                                        <div class="col"><div class="font-weight-medium m-0 text-dark">{{ __('Filters') }}</div></div>
                                        <div class="col-auto">
                                            @if(request()->input('search') || request()->input('sort'))
                                                <a href="{{ route('admin.cronjobs') }}" class="text-secondary">{{ __('Reset') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

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
        @if(count($cronjobs) == 0)
            {{ __('No results found.') }}
        @else
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item px-0 text-muted">
                    <div class="row align-items-center">
                        <div class="col-12 col-sm">{{ __('Name') }}</div>
                        <div class="col-12 col-sm-auto">{{ __('Date') }}</div>
                    </div>
                </div>

                @foreach($cronjobs as $cronjob)
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-sm d-flex text-truncate">
                                @if($cronjob->name == 'cache')
                                    <div class="badge badge-primary text-truncate">
                                        {{ $cronjob->name }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 col-sm-auto text-truncate">
                                {{ $cronjob->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')) }} {{ $cronjob->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format('H:i:s') }}
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-3 align-items-center">
                    <div class="row">
                        <div class="col">
                            <div class="mt-2 mb-3">{{ __('Showing :from-:to of :total', ['from' => $cronjobs->firstItem(), 'to' => $cronjobs->lastItem(), 'total' => $cronjobs->total()]) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            {{ $cronjobs->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="regenerate-modal" tabindex="-1" role="dialog" aria-labelledby="regenerate-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h6 class="modal-title" id="regenerate-modal-label">{{ __('Regenerate') }}</h6>
                <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                </button>
            </div>
            <div class="modal-body">
                <div>{{ __('If you regenerate the cron job key, you will need to update the cron job tasks with the new commands.') }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('admin.cronjobs') }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <button type="submit" class="btn btn-danger">{{ __('Regenerate') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    'use strict';

    window.addEventListener('DOMContentLoaded', function () {
        new ClipboardJS('.btn');
    });
</script>