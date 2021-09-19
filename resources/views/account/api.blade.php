@section('site_title', formatTitle([__('API'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('account'), 'title' => __('Account')],
    ['title' => __('API')]
]])

<h2 class="mb-3 d-inline-block">{{ __('API') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('API') }}</div></div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <div class="form-group">
            <label for="i-api-token">{{ __('API key') }}</label>
            <div class="input-group">
                <input type="text" id="i-api-token" class="form-control" value="{{ $user->api_token }}" readonly>
                <div class="input-group-append">
                    <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-api-token">{{ __('Copy') }}</div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#regenerate-modal">{{ __('Regenerate') }}</button>
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
                <div>{{ __('Are you sure you want to regenerate your API key?') }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('account.api') }}" method="post" enctype="multipart/form-data">

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