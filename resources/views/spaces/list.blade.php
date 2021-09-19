@section('site_title', formatTitle([__('Spaces'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['title' => __('Spaces')]
]])

<div class="d-flex">
    <div class="flex-grow-1">
        <h2 class="mb-3 d-inline-block">{{ __('Spaces') }}</h2>
    </div>
    <div>
        <a href="{{ route('spaces.new') }}" class="btn btn-primary mb-3">{{ __('New') }}</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('Spaces') }}</div></div>
            <div class="col-auto">
                <form method="GET" action="{{ route('spaces') }}">
                    <div class="input-group input-group-sm">
                        <input class="form-control" name="search" placeholder="{{ __('Search') }}" value="{{ app('request')->input('search') }}">
                        <div class="input-group-append">
                            <button type="button" class="btn {{ request()->input('search') || request()->input('sort') ? 'btn-primary' : 'btn-outline-primary' }} d-flex align-items-center dropdown-toggle dropdown-toggle-split reset-after" data-enable="tooltip" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.filter', ['class' => 'fill-current width-4 height-4'])&#8203;</button>
                            <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow width-64" id="search-filters">
                                <div class="dropdown-header py-1">
                                    <div class="row">
                                        <div class="col"><div class="font-weight-medium m-0 text-dark text-truncate">{{ __('Filters') }}</div></div>
                                        <div class="col-auto">
                                            @if(request()->input('search') || request()->input('sort'))
                                                <a href="{{ route('spaces') }}" class="text-secondary">{{ __('Reset') }}</a>
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
        @include('shared.message')

        @if(count($spaces) == 0)
            {{ __('No results found.') }}
        @else
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item px-0 text-muted">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-8 d-flex">
                                    {{ __('Name') }}
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

                @foreach($spaces as $space)
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col text-truncate">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg-8 d-flex">
                                        <div class="text-truncate">
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center text-truncate" dir="ltr">
                                                    <div class="width-4 height-4 rounded-circle bg-{{ formatSpace()[$space->color] }} {{ (__('lang_dir' == 'rtl' ? 'ml-3' : 'mr-3')) }}"></div>
                                                    <div class="text-truncate"><a href="{{ route('spaces.edit', ['id' => $space->id]) }}">{{ $space->name }}</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-none d-lg-block col-lg-2">
                                        <a href="{{ route('links', ['space' => $space->id]) }}" class="text-dark">{{ $space->totalLinks }}</a>
                                    </div>

                                    <div class="d-none d-lg-block col-lg-2">
                                        <div class="text-truncate" data-enable="tooltip" title="{{ $space->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d') . ' H:i:s') }}">{{ $space->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('spaces.edit', $space->id) }}" class="btn btn-outline-primary btn-sm">{{ __('Edit') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-3 align-items-center">
                    <div class="row">
                        <div class="col">
                            <div class="mt-2 mb-3">{{ __('Showing :from-:to of :total', ['from' => $spaces->firstItem(), 'to' => $spaces->lastItem(), 'total' => $spaces->total()]) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            {{ $spaces->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>