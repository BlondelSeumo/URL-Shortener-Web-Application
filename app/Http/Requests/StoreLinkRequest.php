<?php

namespace App\Http\Requests;

use App\Rules\LinkDisabledGateRule;
use App\Rules\LinkDomainGateRule;
use App\Rules\LinkExpirationGateRule;
use App\Rules\FieldNotPresentRule;
use App\Rules\LinkPixelGateRule;
use App\Rules\LinkTargetingGateRule;
use App\Rules\LinkPasswordGateRule;
use App\Rules\LinkSpaceGateRule;
use App\Rules\ValidateAliasRule;
use App\Rules\ValidateBadWordsRule;
use App\Rules\ValidateCountryKeyRule;
use App\Rules\ValidateDeepLinkRule;
use App\Rules\ValidateDomainOwnershipRule;
use App\Rules\LinkLimitGateRule;
use App\Rules\ValidateGuestDomainRule;
use App\Rules\ValidateLanguageKeyRule;
use App\Rules\ValidatePixelOwnersipRule;
use App\Rules\ValidatePlatformKeyRule;
use App\Rules\ValidateSpaceOwnershipRule;
use App\Rules\ValidateUrlRule;
use App\Rules\ValidateUrlsCountRule;
use App\Rules\ValidateUrlsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Prevent guest users from creating multi-links
        if ($this->input('multi_link') && Auth::check() == false) {
            abort(403);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // If the user is logged-in
        if (Auth::check()) {
            if ($this->input('multi_link')) {
                $rules = [
                    'urls' => ['required', new ValidateBadWordsRule(), new LinkLimitGateRule($this->user()), new ValidateUrlsRule(), new ValidateUrlsCountRule()],
                    'space' => ['nullable', 'integer', new ValidateSpaceOwnershipRule($this->user()->id), new LinkSpaceGateRule($this->user())],
                    'domain' => ['nullable', 'integer', new ValidateDomainOwnershipRule($this->user()), new LinkDomainGateRule($this->user())]
                ];
            } else {
                $rules = [
                    'url' => ['required', 'max:2048', new ValidateUrlRule(), new ValidateBadWordsRule(), new LinkLimitGateRule($this->user()), new ValidateDeepLinkRule($this->user())],
                    'alias' => ['nullable', 'alpha_dash', 'max:255', new ValidateAliasRule()],
                    'password' => ['nullable', 'string', 'max:128', new LinkPasswordGateRule($this->user())],
                    'space' => ['nullable', 'integer', new ValidateSpaceOwnershipRule($this->user()->id), new LinkSpaceGateRule($this->user())],
                    'domain' => ['nullable', 'integer', new ValidateDomainOwnershipRule($this->user()), new LinkDomainGateRule($this->user())],
                    'pixels' => ['nullable', new ValidatePixelOwnersipRule($this->user()->id), new LinkPixelGateRule($this->user())],
                    'disabled' => ['nullable', 'boolean', new LinkDisabledGateRule($this->user())],
                    'privacy' => ['nullable', 'integer', 'between:0,2'],
                    'privacy_password' => [(in_array($this->input('privacy'), [0, 1]) ? 'nullable' : 'sometimes'), 'string', 'min:1', 'max:128'],
                    'expiration_url' => ['nullable', new ValidateUrlRule(), 'max:2048', new ValidateBadWordsRule(), new LinkExpirationGateRule($this->user())],
                    'expiration_date' => ['nullable', 'required_with:expiration_time', 'date_format:Y-m-d', new LinkExpirationGateRule($this->user())],
                    'expiration_time' => ['nullable', 'required_with:expiration_date', 'date_format:H:i', new LinkExpirationGateRule($this->user())],
                    'expiration_clicks' => ['nullable', 'integer', 'min:0', 'digits_between:0,9', new LinkExpirationGateRule($this->user())],
                    'target_type' => ['nullable', 'integer', 'min:0', 'max:4'],
                    'country.*.key' => ['nullable', 'required_with:country.*.value', new ValidateCountryKeyRule(), new LinkTargetingGateRule($this->user())],
                    'country.*.value' => ['nullable', 'required_with:country.*.key', 'max:2048', new ValidateUrlRule(), new ValidateBadWordsRule(), new ValidateDeepLinkRule($this->user())],
                    'platform.*.key' => ['nullable', 'required_with:platform.*.value', new ValidatePlatformKeyRule(), new LinkTargetingGateRule($this->user())],
                    'platform.*.value' => ['nullable', 'required_with:platform.*.key', 'max:2048', new ValidateUrlRule(), new ValidateBadWordsRule(), new ValidateDeepLinkRule($this->user())],
                    'language.*.key' => ['nullable', 'required_with:language.*.value', new ValidateLanguageKeyRule(), new LinkTargetingGateRule($this->user())],
                    'language.*.value' => ['nullable', 'required_with:language.*.key', 'max:2048', new ValidateUrlRule(), new ValidateBadWordsRule(), new ValidateDeepLinkRule($this->user())],
                    'rotation.*.value' => ['nullable', 'max:2048', new ValidateUrlRule(), new ValidateBadWordsRule(), new ValidateDeepLinkRule($this->user()), new LinkTargetingGateRule($this->user())]
                ];
            }
        }
        // If the user is not logged in
        else {
            $rules = [
                'url' => ['required', 'max:2048', new ValidateUrlRule(), new ValidateDeepLinkRule(null), new ValidateBadWordsRule()],
                'alias' => [new FieldNotPresentRule()],
                'password' => [new FieldNotPresentRule()],
                'space' => [new FieldNotPresentRule()],
                'domain' => [new ValidateGuestDomainRule()],
                'pixels' => [new FieldNotPresentRule()],
                'disabled' => [new FieldNotPresentRule()],
                'privacy' => [new FieldNotPresentRule()],
                'privacy_password' => [new FieldNotPresentRule()],
                'expiration_url' => [new FieldNotPresentRule()],
                'expiration_date' => [new FieldNotPresentRule()],
                'expiration_time' => [new FieldNotPresentRule()],
                'expiration_clicks' => [new FieldNotPresentRule()],
                'target_type' => [new FieldNotPresentRule()],
                'country.*.key' => [new FieldNotPresentRule()],
                'country.*.value' => [new FieldNotPresentRule()],
                'platform.*.key' => [new FieldNotPresentRule()],
                'platform.*.value' => [new FieldNotPresentRule()],
                'rotation.*.value' => [new FieldNotPresentRule()],
                'g-recaptcha-response' => [(config('settings.captcha_shorten') ? 'required' : 'sometimes'), 'captcha']
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'url' => __('Link'),
            'alias' => __('Alias'),
            'password' => __('Password'),
            'space' => __('Space'),
            'domain' => __('Domain'),
            'pixels' => __('Pixels'),
            'disabled' => __('Disabled'),
            'privacy' => __('Stats'),
            'privacy_password' => __('Password'),
            'expiration_url' => __('Expiration link'),
            'expiration_date' => __('Expiration date'),
            'expiration_time' => __('Expiration time'),
            'expiration_clicks' => __('Expiration clicks'),
            'country.*.key' => __('Country'),
            'country.*.value' => __('Link'),
            'platform.*.key' => __('Platform'),
            'platform.*.value' => __('Link'),
            'language.*.key' => __('Language'),
            'language.*.value' => __('Link'),
            'rotation.*.value' => __('Link')
        ];
    }
}
