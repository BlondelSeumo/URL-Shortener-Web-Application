<?php

namespace App\Http\Requests;

use App\Rules\ValidateDNSRule;
use App\Rules\ValidateDomainNameRule;
use App\Rules\DomainLimitGateRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDomainRequest extends FormRequest
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
            'name' => ['required', 'url', 'max:255', new DomainLimitGateRule($this->user()), new ValidateDomainNameRule(), new ValidateDNSRule()],
            'index_page' => ['nullable', 'url', 'max:255'],
            'not_found_page' => ['nullable', 'url', 'max:255']
        ];
    }
}
