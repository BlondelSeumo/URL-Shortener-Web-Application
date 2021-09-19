@section('site_title', formatTitle([__('Settings'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('Settings')],
]])

<h2 class="mb-3 d-inline-block">{{ __('Settings') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header"><div class="font-weight-medium py-1">{{ __('Payment processors') }}</div></div>
    <div class="card-body">

        <ul class="nav nav-pills d-flex flex-fill flex-column flex-md-row mb-3" id="pills-tab" role="tablist">
            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link active" id="pills-stripe-tab" data-toggle="pill" href="#pills-stripe" role="tab" aria-controls="pills-stripe" aria-selected="true">{{ __('Stripe') }}</a>
            </li>

            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link" id="pills-paypal-tab" data-toggle="pill" href="#pills-paypal" role="tab" aria-controls="pills-paypal" aria-selected="false">{{ __('PayPal') }}</a>
            </li>

            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link" id="pills-coinbase-tab" data-toggle="pill" href="#pills-coinbase" role="tab" aria-controls="pills-coinbase" aria-selected="false">{{ __('Coinbase') }}</a>
            </li>

            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link" id="pills-bank-tab" data-toggle="pill" href="#pills-bank" role="tab" aria-controls="pills-bank" aria-selected="false">{{ __('Bank') }}</a>
            </li>
        </ul>

        @include('shared.message')

        <form action="{{ route('admin.payment_processors') }}" method="post" enctype="multipart/form-data">

            @csrf

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-stripe" role="tabpanel" aria-labelledby="pills-stripe-tab">
                    <div class="form-group">
                        <label for="i-stripe">{{ __('Enabled') }}</label>
                        <select name="stripe" id="i-stripe" class="custom-select{{ $errors->has('stripe') ? ' is-invalid' : '' }}">
                            @foreach([1 => __('Yes'), 0 => __('No')] as $key => $value)
                                <option value="{{ $key }}" @if ((old('stripe') !== null && old('stripe') == $key) || (config('settings.stripe') == $key && old('stripe') == null)) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('stripe'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('stripe') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-stripe-key">{{ __('Publishable key') }}</label>
                        <input type="text" name="stripe_key" id="i-stripe-key" class="form-control{{ $errors->has('stripe_key') ? ' is-invalid' : '' }}" value="{{ old('stripe_key') ?? config('settings.stripe_key') }}">
                        @if ($errors->has('stripe_key'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('stripe_key') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-stripe-secret">{{ __('Secret key') }}</label>
                        <input type="password" name="stripe_secret" id="i-stripe-secret" class="form-control{{ $errors->has('stripe_secret') ? ' is-invalid' : '' }}" value="{{ old('stripe_secret') ?? config('settings.stripe_secret') }}">
                        @if ($errors->has('stripe_secret'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('stripe_secret') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-stripe-wh-secret">{{ __('Signing secret') }}</label>
                        <input type="password" name="stripe_wh_secret" id="i-stripe-wh-secret" class="form-control{{ $errors->has('stripe_wh_secret') ? ' is-invalid' : '' }}" value="{{ old('stripe_wh_secret') ?? config('settings.stripe_wh_secret') }}">
                        @if ($errors->has('stripe_wh_secret'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('stripe_wh_secret') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-stripe-wh-url">{{ __('Webhook URL') }}</label>
                        <div class="input-group">
                            <input type="text" dir="ltr" name="stripe_wh_url" id="i-stripe-wh-url" class="form-control" value="{{ route('webhooks.stripe') }}" readonly>
                            <div class="input-group-append">
                                <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-stripe-wh-url">{{ __('Copy') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-paypal" role="tabpanel" aria-labelledby="pills-paypal-tab">
                    <div class="form-group">
                        <label for="i-paypal">{{ __('Enabled') }}</label>
                        <select name="paypal" id="i-paypal" class="custom-select{{ $errors->has('paypal') ? ' is-invalid' : '' }}">
                            @foreach([1 => __('Yes'), 0 => __('No')] as $key => $value)
                                <option value="{{ $key }}" @if ((old('paypal') !== null && old('paypal') == $key) || (config('settings.paypal') == $key && old('paypal') == null)) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('paypal'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('paypal') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-paypal-mode">{{ __('Mode') }}</label>
                        <select name="paypal_mode" id="i-paypal-mode" class="custom-select{{ $errors->has('paypal_mode') ? ' is-invalid' : '' }}">
                            @foreach(['live' => __('Live'), 'sandbox' => __('Sandbox')] as $key => $value)
                                <option value="{{ $key }}" @if ((old('paypal_mode') !== null && old('paypal_mode') == $key) || (config('settings.paypal_mode') == $key && old('paypal_mode') == null)) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('paypal_mode'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('paypal_mode') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-paypal-client-id">{{ __('Client ID') }}</label>
                        <input type="text" name="paypal_client_id" id="i-paypal-client-id" class="form-control{{ $errors->has('paypal_client_id') ? ' is-invalid' : '' }}" value="{{ old('paypal_client_id') ?? config('settings.paypal_client_id') }}">
                        @if ($errors->has('paypal_client_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('paypal_client_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-paypal-secret">{{ __('Secret') }}</label>
                        <input type="password" name="paypal_secret" id="i-paypal-secret" class="form-control{{ $errors->has('paypal_secret') ? ' is-invalid' : '' }}" value="{{ old('paypal_secret') ?? config('settings.paypal_secret') }}">
                        @if ($errors->has('paypal_secret'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('paypal_secret') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-paypal-webhook-id">{{ __('Webhook ID') }}</label>
                        <input type="text" name="paypal_webhook_id" id="i-paypal-webhook-id" class="form-control{{ $errors->has('paypal_webhook_id') ? ' is-invalid' : '' }}" value="{{ old('paypal_webhook_id') ?? config('settings.paypal_webhook_id') }}">
                        @if ($errors->has('paypal_webhook_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('paypal_webhook_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-paypal-wh-url">{{ __('Webhook URL') }}</label>
                        <div class="input-group">
                            <input type="text" dir="ltr" name="paypal_wh_url" id="i-paypal-wh-url" class="form-control" value="{{ route('webhooks.paypal') }}" readonly>
                            <div class="input-group-append">
                                <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-paypal-wh-url">{{ __('Copy') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-coinbase" role="tabpanel" aria-labelledby="pills-coinbase-tab">
                    <div class="form-group">
                        <label for="i-coinbase">{{ __('Enabled') }}</label>
                        <select name="coinbase" id="i-coinbase" class="custom-select{{ $errors->has('coinbase') ? ' is-invalid' : '' }}">
                            @foreach([1 => __('Yes'), 0 => __('No')] as $key => $value)
                                <option value="{{ $key }}" @if ((old('coinbase') !== null && old('coinbase') == $key) || (config('settings.coinbase') == $key && old('coinbase') == null)) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('coinbase'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('coinbase') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-coinbase-key">{{ __('Client ID') }}</label>
                        <input type="text" name="coinbase_key" id="i-coinbase-key" class="form-control{{ $errors->has('coinbase_key') ? ' is-invalid' : '' }}" value="{{ old('coinbase_key') ?? config('settings.coinbase_key') }}">
                        @if ($errors->has('coinbase_key'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('coinbase_key') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-coinbase-wh-secret">{{ __('Webhook shared secret') }}</label>
                        <input type="password" name="coinbase_wh_secret" id="i-coinbase-wh-secret" class="form-control{{ $errors->has('coinbase_wh_secret') ? ' is-invalid' : '' }}" value="{{ old('coinbase_wh_secret') ?? config('settings.coinbase_wh_secret') }}">
                        @if ($errors->has('coinbase_wh_secret'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('coinbase_wh_secret') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-coinbase-wh-url">{{ __('Webhook URL') }}</label>
                        <div class="input-group">
                            <input type="text" dir="ltr" name="coinbase_wh_url" id="i-coinbase-wh-url" class="form-control" value="{{ route('webhooks.coinbase') }}" readonly>
                            <div class="input-group-append">
                                <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-coinbase-wh-url">{{ __('Copy') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-bank" role="tabpanel" aria-labelledby="pills-bank-tab">
                    <div class="form-group">
                        <label for="i-bank">{{ __('Enabled') }}</label>
                        <select name="bank" id="i-bank" class="custom-select{{ $errors->has('bank') ? ' is-invalid' : '' }}">
                            @foreach([1 => __('Yes'), 0 => __('No')] as $key => $value)
                                <option value="{{ $key }}" @if ((old('bank') !== null && old('bank') == $key) || (config('settings.bank') == $key && old('bank') == null)) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('bank'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-bank-account-owner">{{ __('Account owner') }}</label>
                        <input type="text" name="bank_account_owner" id="i-bank-account-owner" class="form-control{{ $errors->has('bank_account_owner') ? ' is-invalid' : '' }}" value="{{ old('bank_account_owner') ?? config('settings.bank_account_owner') }}">
                        @if ($errors->has('bank_account_owner'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_account_owner') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-bank-account-number">{{ __('Account number') }}</label>
                        <input type="text" name="bank_account_number" id="i-bank-account-number" class="form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{ old('bank_account_number') ?? config('settings.bank_account_number') }}">
                        @if ($errors->has('bank_account_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_account_number') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-bank-name">{{ __('Bank name') }}</label>
                        <input type="text" name="bank_name" id="i-bank-name" class="form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" value="{{ old('bank_name') ?? config('settings.bank_name') }}">
                        @if ($errors->has('bank_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-bank-routing-number">{{ __('Routing number') }}</label>
                        <input type="text" name="bank_routing_number" id="i-bank-routing-number" class="form-control{{ $errors->has('bank_routing_number') ? ' is-invalid' : '' }}" value="{{ old('bank_routing_number') ?? config('settings.bank_routing_number') }}">
                        @if ($errors->has('bank_routing_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_routing_number') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-bank-iban">{{ __('IBAN') }}</label>
                        <input type="text" name="bank_iban" id="i-bank-iban" class="form-control{{ $errors->has('bank_iban') ? ' is-invalid' : '' }}" value="{{ old('bank_iban') ?? config('settings.bank_iban') }}">
                        @if ($errors->has('bank_iban'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_iban') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-bank-bic-swift">{{ __('BIC') }} / {{ __('SWIFT') }}</label>
                        <input type="text" name="bank_bic_swift" id="i-bank-bic-swift" class="form-control{{ $errors->has('bank_bic_swift') ? ' is-invalid' : '' }}" value="{{ old('bank_bic_swift') ?? config('settings.bank_bic_swift') }}">
                        @if ($errors->has('bank_bic_swift'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_bic_swift') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>

    </div>
</div>

<script>
    'use strict';

    window.addEventListener('DOMContentLoaded', function () {
        new ClipboardJS('.btn');
    });
</script>