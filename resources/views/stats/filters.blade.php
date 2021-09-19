<div class="col">
    <form method="GET" action="{{ route(Route::currentRouteName(), ['id' => $link->id, 'from' => $range['from'], 'to' => $range['to']]) }}" class="d-md-flex">
        <div class="input-group input-group-sm">
            <input class="form-control" name="search" placeholder="{{ __('Search') }}" value="{{ app('request')->input('search') }}">
            <div class="input-group-append">
                <button type="button" class="btn {{ request()->input('sort') ? 'btn-primary' : 'btn-outline-primary' }} d-flex align-items-center dropdown-toggle dropdown-toggle-split reset-after" data-enable="tooltip" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.filter', ['class' => 'fill-current width-4 height-4'])</button>
                <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow width-64" id="search-filters">
                    <div class="dropdown-header py-1">
                        <div class="row">
                            <div class="col"><div class="font-weight-medium m-0 text-dark">{{ __('Filters') }}</div></div>
                            <div class="col-auto">
                                @if(request()->input('sort'))
                                    <a href="{{ route(Route::currentRouteName(), ['id' => $link->id, 'from' => $range['from'], 'to' => $range['to']]) }}" class="text-secondary">{{ __('Reset') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <input name="from" type="hidden" value="{{ $range['from'] }}">
                    <input name="to" type="hidden" value="{{ $range['to'] }}">

                    <div class="dropdown-divider"></div>

                    <div class="form-group d-flex flex-column px-4">
                        <label for="i-sort" class="small">{{ __('Sort') }}</label>
                        <select name="sort" id="i-sort" class="custom-select custom-select-sm position-relative d-flex flex-column">
                            @foreach(['max' => __('Best performing'), 'min' => __('Least performing')] as $key => $value)
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
<div class="col-auto">
    <a href="{{ route($export, ['id' => $link->id] + Request::query()) }}" data-toggle="modal" data-target="#export-modal" class="btn btn-sm btn-outline-primary d-flex align-items-center" data-enable="tooltip" title="{{ __('Export') }}">@include('icons.export', ['class' => 'fill-current width-4 height-4'])&#8203;</a>

    <div class="modal fade" id="export-modal" tabindex="-1" role="dialog" aria-labelledby="export-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h6 class="modal-title" id="export-modal-label">{{ __('Export') }}</h6>
                    <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($remoteUser->can('dataExport', ['App\Link', $remoteUser->plan->features->data_export]) || (Auth::check() && Auth::user()->role == 1))
                        {{ __('Are you sure you want to export this table?') }}
                    @else
                        @if(paymentProcessors())
                            @if(Auth::check() && $remoteUser->id == Auth::user()->id)
                                @include('shared.features.locked')
                            @else
                                @include('shared.features.unavailable')
                            @endif
                        @else
                            @include('shared.features.unavailable')
                        @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    @if($remoteUser->can('dataExport', ['App\Link', $remoteUser->plan->features->data_export]) || (Auth::check() && Auth::user()->role == 1))
                        <a href="{{ route($export, ['id' => $link->id] + Request::query()) }}" target="_self" class="btn btn-primary" id="exportButton">{{ __('Export') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        'use strict';

        window.addEventListener('DOMContentLoaded', function () {
            jQuery('#exportButton').on('click', function () {
                jQuery('#export-modal').modal('hide');
            });
        });
    </script>
</div>