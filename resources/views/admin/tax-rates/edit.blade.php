@section('site_title', formatTitle([__('Edit'), __('Tax rate'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['url' => route('admin.tax_rates'), 'title' => __('Tax rates')],
    ['title' => __('Edit')],
]])

<h2 class="mb-3 d-inline-block">{{ __('Edit') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">
                    {{ __('Tax rate') }}
                    @if($taxRate->trashed())
                        <span class="badge badge-danger">{{ __('Disabled') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('admin.tax_rates.edit', $taxRate->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-name">{{ __('Name') }}</label>
                <input type="text" name="name" id="i-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') ?? $taxRate->name }}" disabled>
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-regions">{{ __('Regions') }}</label>
                <select name="regions[]" id="i-regions" class="custom-select{{ $errors->has('regions') ? ' is-invalid' : '' }}" multiple>
                    @foreach(config('countries') as $key => $value)
                        <option value="{{ $key }}" @if((old('regions') !== null && in_array($key, old('regions'))) || old('regions') == null && in_array($key, $taxRate->regions ?? [])) selected @endif>{{ __($value) }}</option>
                    @endforeach
                </select>
                @if ($errors->has('regions'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('regions') }}</strong>
                    </span>
                @endif
                <small id="regionsHelp" class="form-text text-muted">{{ __('Leave empty to apply the tax rate on all regions.') }}</small>
            </div>

            <div class="form-row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="i-percentage">{{ __('Percentage') }}</label>
                        <div class="input-group">
                            <input type="text" name="percentage" id="i-percentage" class="form-control{{ $errors->has('percentage') ? ' is-invalid' : '' }}" value="{{ old('percentage') ?? $taxRate->percentage }}" disabled>
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        @if ($errors->has('percentage'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('percentage') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <label for="i-type">{{ __('Type') }}</label>
                    <select name="type" id="i-type" class="custom-select{{ $errors->has('type') ? ' is-invalid' : '' }}" disabled>
                        @foreach([0 => __('Inclusive'), 1 => __('Exclusive')] as $key => $value)
                            <option value="{{ $key }}" @if ((old('type') !== null && old('type') == $key) || ($taxRate->type == $key && old('type') == null)) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('type'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
                <div class="col-auto">
                    @if($taxRate->trashed())
                        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#restore-modal">{{ __('Restore') }}</button>
                    @else
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#disable-modal">{{ __('Disable') }}</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="disable-modal" tabindex="-1" role="dialog" aria-labelledby="disable-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h6 class="modal-title" id="disable-modal-label">{{ __('Disable') }}</h6>
                <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to disable :name?', ['name' => $taxRate->name]) }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('admin.tax_rates.disable', $taxRate->id) }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <button type="submit" class="btn btn-danger">{{ __('Disable') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="restore-modal" tabindex="-1" role="dialog" aria-labelledby="restore-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h6 class="modal-title" id="restore-modal-label">{{ __('Restore') }}</h6>
                <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                </button>
            </div>
            <div class="modal-body">
                <div>{{ __('Are you sure you want to restore :name?', ['name' => $taxRate->name]) }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('admin.tax_rates.restore', $taxRate->id) }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <button type="submit" class="btn btn-success">{{ __('Restore') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>