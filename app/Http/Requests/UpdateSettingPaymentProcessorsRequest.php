<?php

namespace App\Http\Requests;

use App\Rules\ValidateExtendedLicenseRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingPaymentProcessorsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stripe' => ['required', 'integer', 'between:0,1', new ValidateExtendedLicenseRule()],
            'stripe_key' => ['required_if:stripe,1'],
            'stripe_secret' => ['required_if:stripe,1'],
            'stripe_wh_secret' => ['required_if:stripe,1'],
            'paypal' => ['required', 'integer', 'between:0,1', new ValidateExtendedLicenseRule()],
            'paypal_mode' => ['required_if:paypal,1'],
            'paypal_client_id' => ['required_if:paypal,1'],
            'paypal_secret' => ['required_if:paypal,1'],
            'paypal_webhook_id' => ['required_if:paypal,1'],
            'coinbase' => ['required', 'integer', 'between:0,1', new ValidateExtendedLicenseRule()],
            'coinbase_key' => ['required_if:coinbase,1'],
            'coinbase_wh_secret' => ['required_if:coinbase,1'],
            'bank' => ['required', 'integer', 'between:0,1', new ValidateExtendedLicenseRule()],
        ];
    }
}
