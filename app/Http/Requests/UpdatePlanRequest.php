<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
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
            'name' => ['required', 'max:64'],
            'description' => ['required', 'max:256'],
            'amount_month' => ['sometimes', 'numeric', 'min:0.01', 'max:9999999999'],
            'amount_year' => ['sometimes', 'numeric', 'min:0.01', 'max:9999999999'],
            'coupons' => ['sometimes', 'nullable'],
            'tax_rates' => ['sometimes', 'nullable'],
            'trial_days' => ['sometimes', 'integer', 'min:0', 'max:3650'],
            'visibility' => ['sometimes', 'integer', 'between:0,1'],
            'color' => ['required', 'max:32'],
            'features.links' => ['required', 'integer'],
            'features.spaces' => ['required', 'integer'],
            'features.domains' => ['required', 'integer'],
            'features.password' => ['required', 'integer', 'between:0,1'],
            'features.expiration' => ['required', 'integer', 'between:0,1'],
            'features.stats' => ['required', 'integer', 'between:0,1'],
            'features.targeting' => ['required', 'integer', 'between:0,1'],
            'features.disabled' => ['required', 'integer', 'between:0,1'],
            'features.api' => ['required', 'integer', 'between:0,1'],
            'features.global_domains' => ['required', 'integer', 'between:0,1'],
            'features.deep_links' => ['required', 'integer', 'between:0,1'],
            'features.data_export' => ['required', 'integer', 'between:0,1']
        ];
    }
}
