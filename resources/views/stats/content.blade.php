@extends('layouts.app')

@section('content')
<script src="{{ asset('js/app.extras.js') }}" defer></script>
<div class="bg-base-1 flex-fill">
    @include('stats.header')

    <div class="container py-3 my-3">
        @include('stats.' . $view)

        <div class="row mt-3 small text-muted">
            <div class="col">
                {{ __('This report was generated on :date at :time (UTC :offset).', ['date' => \Carbon\Carbon::now()->format(__('Y-m-d')), 'time' => \Carbon\Carbon::now()->format('H:i:s'), 'offset' => \Carbon\CarbonTimeZone::create(config('app.timezone'))->toOffsetName()]) }} <a href="{{ Request::fullUrl() }}">{{ __('Refresh report') }}</a>
            </div>
        </div>
    </div>
</div>
@include('shared.modals.share-link')
@include('shared.modals.delete-link')
@include('shared.sidebars.user')
@endsection