@section('site_title', formatTitle([__('Edit'), __('Language'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['url' => route('admin.languages'), 'title' => __('Languages')],
    ['title' => __('Edit')],
]])

<h2 class="mb-3 d-inline-block">{{ __('Edit') }}</h2>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-header align-items-center">
        <div class="font-weight-medium py-1">{{ __('Language') }}</div>
    </div>
    <div class="card-body">

        @include('shared.message')

        <div class="row">
            <div class="col-12 col-lg-6 mb-3">
                <div class="text-muted">{{ __('Name') }}</div>
                <div>{{ $language->name }}</div>
            </div>
            <div class="col-12 col-lg-6 mb-3">
                <div class="text-muted">{{ __('Code') }}</div>
                <div>{{ $language->code }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <form action="{{ route('admin.languages.edit', $language->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="default" id="i-default" @if($language->default) checked disabled @endif>
                            <label class="custom-control-label" for="i-default">{{ __('Default') }}</label>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-modal" @if($language->default) disabled @endif>{{ __('Delete') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
                {{ __('Are you sure you want to delete :name?', ['name' => $language->name]) }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('admin.languages.destroy', $language->id) }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>