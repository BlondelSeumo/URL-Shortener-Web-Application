@if(count(config('app.locales')) > 1)
    <div class="nav-item d-flex">
        <a href="#" class="nav-link py-1 d-flex align-items-center text-secondary" data-toggle="modal" data-target="#change-language-modal" data-enable="tooltip" title="{{ __('Change language') }}">
            @include('icons.language', ['class' => 'width-4 height-4 fill-current ' . (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])
            <span class="text-muted">{{ config('app.locales')[config('app.locale')] }}</span>
        </a>
    </div>

    <div class="modal fade" id="change-language-modal" tabindex="-1" role="dialog" aria-labelledby="change-language-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h6 class="modal-title" id="change-language-modal-label">{{ __('Change language') }}</h6>
                    <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                    </button>
                </div>
                <form action="{{ route('locale') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            @foreach(config('app.locales') as $code => $name)
                                <div class="col-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="i-language-{{ $code }}" name="locale" class="custom-control-input" value="{{ $code }}" @if(config('app.locale') == $code) checked @endif>
                                        <label class="custom-control-label" for="i-language-{{ $code }}" lang="{{ $code }}">{{ $name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif