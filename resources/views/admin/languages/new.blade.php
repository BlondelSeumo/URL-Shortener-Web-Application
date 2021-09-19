@section('site_title', formatTitle([__('New'), __('Language'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['url' => route('admin.languages'), 'title' => __('Languages')],
    ['title' => __('New')],
]])

<h2 class="mb-3 d-inline-block">{{ __('New') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header"><div class="font-weight-medium py-1">{{ __('Language') }}</div></div>
    <div class="card-body">
        <form action="{{ route('admin.languages.new') }}" method="post" enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="i-language">{{ __('Language') }}</label>
                <div class="custom-file">
                    <input type="file" name="language" id="i-language" class="custom-file-input{{ $errors->has('language') ? ' is-invalid' : '' }}" accept=".json">
                    @if ($errors->has('language'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('language') }}</strong>
                        </span>
                    @endif
                    <label class="custom-file-label" for="i-language" data-browse="{{ __('Browse') }}">{{ __('Choose file') }}</label>
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>