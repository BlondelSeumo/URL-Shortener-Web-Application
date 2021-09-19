@section('site_title', formatTitle([__('Pixels'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['title' => __('Pixels')]
]])

<div class="d-flex">
    <div class="flex-grow-1">
        <h2 class="mb-3 d-inline-block">{{ __('Pixels') }}</h2>
    </div>
    <div>
        <a href="{{ route('pixels.new') }}" class="btn btn-primary mb-3">{{ __('New') }}</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('Pixels') }}</div></div>
            <div class="col-auto">
                <form method="GET" action="{{ route('pixels') }}">
                    <div class="input-group input-group-sm">
                        <input class="form-control" name="search" placeholder="{{ __('Search') }}" value="{{ app('request')->input('search') }}">
                        <div class="input-group-append">
                            <button type="button" class="btn {{ request()->input('search') || request()->input('type') || request()->input('sort') ? 'btn-primary' : 'btn-outline-primary' }} d-flex align-items-center dropdown-toggle dropdown-toggle-split reset-after" data-enable="tooltip" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.filter', ['class' => 'fill-current width-4 height-4'])&#8203;</button>
                            <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow width-64" id="search-filters">
                                <div class="dropdown-header py-1">
                                    <div class="row">
                                        <div class="col"><div class="font-weight-medium m-0 text-dark text-truncate">{{ __('Filters') }}</div></div>
                                        <div class="col-auto">
                                            @if(request()->input('search') || request()->input('type') || request()->input('sort'))
                                                <a href="{{ route('pixels') }}" class="text-secondary">{{ __('Reset') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <div class="form-group px-4">
                                    <label for="i-type" class="small">{{ __('Type') }}</label>
                                    <select name="type" id="i-type" class="custom-select custom-select-sm">
                                        <option value="">{{ __('All') }}</option>
                                        @foreach(config('pixels') as $key => $value)
                                            <option value="{{ $key }}" @if(request()->input('type') == $key && request()->input('type') !== null) selected @endif>{{ $value['name'] }}</option>
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

        @if(count($pixels) == 0)
            {{ __('No results found.') }}
        @else
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item px-0 text-muted">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-6 d-flex">
                                    {{ __('Name') }}
                                </div>

                                <div class="d-none d-lg-block col-lg-2">
                                    {{ __('Type') }}
                                </div>

                                <div class="d-none d-lg-block col-lg-2">
                                    {{ __('Links') }}
                                </div>

                                <div class="d-none d-lg-block col-lg-2">
                                    {{ __('Created at') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-outline-primary btn-sm invisible">{{ __('Edit') }}</a>
                        </div>
                    </div>
                </div>

                @foreach($pixels as $pixel)
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col text-truncate">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg-6 d-flex">
                                        <div class="text-truncate">
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center text-truncate">
                                                    <img src="{{ asset('/images/icons/pixels/' . md5(strtolower($pixel->type))) }}.svg" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir' == 'rtl' ? 'ml-3' : 'mr-3')) }}">
                                                    <div class="text-truncate"><a href="{{ route('pixels.edit', $pixel->id) }}">{{ $pixel->name }}</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-none d-lg-block col-lg-2">
                                        <div class="text-truncate">
                                            {{ config('pixels')[$pixel->type]['name'] }}
                                        </div>
                                    </div>

                                    <div class="d-none d-lg-block col-lg-2">
                                        <a href="{{ route('links', ['pixel' => $pixel->id]) }}" class="text-dark">{{ $pixel->totalLinks }}</a>
                                    </div>

                                    <div class="d-none d-lg-block col-lg-2">
                                        <div class="text-truncate" data-enable="tooltip" title="{{ $pixel->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d') . ' H:i:s') }}">{{ $pixel->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('pixels.edit', $pixel->id) }}" class="btn btn-outline-primary btn-sm">{{ __('Edit') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-3 align-items-center">
                    <div class="row">
                        <div class="col">
                            <div class="mt-2 mb-3">{{ __('Showing :from-:to of :total', ['from' => $pixels->firstItem(), 'to' => $pixels->lastItem(), 'total' => $pixels->total()]) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            {{ $pixels->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>