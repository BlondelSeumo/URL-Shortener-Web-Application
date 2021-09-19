@extends('layouts.app')

@section('site_title', formatTitle([__('Developers'), config('settings.title')]))

@section('content')
    <div class="bg-base-1 flex-fill">
        <div class="container h-100 py-6">

            <div class="text-center">
                <h2 class="mb-3 d-inline-block">{{ __('Developers') }}</h2>
                <div class="m-auto">
                    <p class="text-muted font-weight-normal font-size-lg mb-4">{{ __('Explore our API documentation.') }}</p>
                </div>
            </div>

            @php
                $resources = [
                    [
                        'icon' => 'icons.link',
                        'title' => 'Links',
                        'description' => 'Manage links',
                        'route' => 'developers.links'
                    ],
                    [
                        'icon' => 'icons.space',
                        'title' => 'Spaces',
                        'description' => 'Manage spaces',
                        'route' => 'developers.spaces'
                    ],
                    [
                        'icon' => 'icons.domain',
                        'title' => 'Domains',
                        'description' => 'Manage domains',
                        'route' => 'developers.domains'
                    ],
                    [
                        'icon' => 'icons.pixel',
                        'title' => 'Pixels',
                        'description' => 'Manage pixels',
                        'route' => 'developers.pixels'
                    ],
                    [
                        'icon' => 'icons.stats',
                        'title' => 'Stats',
                        'description' => 'Manage stats',
                        'route' => 'developers.stats'
                    ],
                    [
                        'icon' => 'icons.account',
                        'title' => 'Account',
                        'description' => 'Manage account',
                        'route' => 'developers.account'
                    ]
                ];
            @endphp

            <div class="row">
                @foreach($resources as $resource)
                    <div class="col-12 col-sm-6 col-md-4 mt-3">
                        <div class="card border-0 h-100 shadow-sm">
                            <div class="card-body d-flex">
                                <div class="d-flex position-relative text-primary width-12 height-12 align-items-center justify-content-center flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                    <div class="position-absolute bg-primary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                                    @include($resource['icon'], ['class' => 'fill-current width-6 height-6'])
                                </div>
                                <div>
                                    <div class="text-dark font-weight-medium">{{ __($resource['title']) }}</div>

                                    <a href="{{ route($resource['route']) }}" class="text-secondary text-decoration-none stretched-link mb-3">{{ __($resource['description']) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@include('shared.sidebars.user')