@php
    $parameters = [
        [
            'name' => 'url',
            'type' => $type,
            'format' => 'string',
            'description' => __('The link to be shortened.')
        ],
        [
            'name' => 'alias',
            'type' => 0,
            'format' => 'string',
            'description' => __('The link alias.')
        ],
        [
            'name' => 'password',
            'type' => 0,
            'format' => 'string',
            'description' => __('The link password.')
        ],
        [
            'name' => 'space',
            'type' => 0,
            'format' => 'integer',
            'description' => __('The space ID the link to be saved under.')
        ],
        [
            'name' => 'domain',
            'type' => 0,
            'format' => 'integer',
            'description' => __('The domain ID the link to be saved under.')
        ],
        [
            'name' => 'pixels',
            'type' => 0,
            'format' => 'array',
            'description' => __('The pixel IDs to be integrated in the link.')
        ],
        [
            'name' => 'disabled',
            'type' => 0,
            'format' => 'integer',
            'description' => __('Whether the link is disabled or not.') . ' ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>0</code>', 'name' => '<span class="font-weight-medium">'.__('Active').'</span>']),
                    __(':value for :name', ['value' => '<code>1</code>', 'name' => '<span class="font-weight-medium">'.__('Disabled').'</span>'])
                    ])
                ]) . ($type ? ' ' . __('Defaults to: :value.', ['value' => '<code>0</code>']) : '')
        ],
        [
            'name' => 'privacy',
            'type' => 0,
            'format' => 'integer',
            'description' => __('Whether the link stats are public or not.') . ' ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>0</code>', 'name' => '<span class="font-weight-medium">'.__('Public').'</span>']),
                    __(':value for :name', ['value' => '<code>1</code>', 'name' => '<span class="font-weight-medium">'.__('Private').'</span>']),
                    __(':value for :name', ['value' => '<code>2</code>', 'name' => '<span class="font-weight-medium">'.__('Password').'</span>'])
                    ])
                ]) . ($type ? ' ' . __('Defaults to: :value.', ['value' => '<code>0</code>']) : '')
        ],
        [
            'name' => 'privacy_password',
            'type' => 0,
            'format' => 'string',
            'description' => __('The password for the statistics page.') . ' ' . __('Only works with :field set to :value.', ['field' => '<code>privacy</code>', 'value' => '<code>2</code>'])
        ],
        [
            'name' => 'expiration_url',
            'type' => 0,
            'format' => 'string',
            'description' => __('The link where the user will be redirected once the link has expired.')
        ],
        [
            'name' => 'expiration_date',
            'type' => 0,
            'format' => 'string',
            'description' => __('The link expiration date in :format format.', ['format' => '<code>YYYY-MM-DD</code>'])
        ],
        [
            'name' => 'expiration_time',
            'type' => 0,
            'format' => 'string',
            'description' => __('The link expiration time in :format format.', ['format' => '<code>HH:MM</code>'])
        ],
        [
            'name' => 'expiration_clicks',
            'type' => 0,
            'format' => 'integer',
            'description' => __('The number of clicks after which the link should expire.')
        ],
        [
            'name' => 'target_type',
            'type' => 0,
            'format' => 'integer',
            'description' => __('The type of targeting.') . ' ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>0</code>', 'name' => '<span class="font-weight-medium">'.__('None').'</span>']),
                    __(':value for :name', ['value' => '<code>1</code>', 'name' => '<span class="font-weight-medium">'.__('Geographic').'</span>']),
                    __(':value for :name', ['value' => '<code>2</code>', 'name' => '<span class="font-weight-medium">'.__('Platform').'</span>']),
                    __(':value for :name', ['value' => '<code>4</code>', 'name' => '<span class="font-weight-medium">'.__('Rotation').'</span>'])
                    ])
                ])
        ],
        [
            'name' => 'country[index][key]',
            'type' => 0,
            'format' => 'string',
            'description' => __('The code of the targeted country.') . ' ' . __('The code must be in :standard standard.', ['standard' => '<a href="https://wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements" target="_blank" rel="nofollow">ISO 3166-1 alpha-2</a>'])
        ],
        [
            'name' => 'country[index][value]',
            'type' => 0,
            'format' => 'string',
            'description' => __('The link where the user will be redirected to.')
        ],
        [
            'name' => 'platform[index][key]',
            'type' => 0,
            'format' => 'string',
            'description' => __('The name of the targeted platform.') . ' ' . __('Possible values are: :values.', ['values' => '<code>'.implode('</code>, <code>', config('platforms')).'</code>'])
        ],
        [
            'name' => 'platform[index][value]',
            'type' => 0,
            'format' => 'string',
            'description' => __('The link where the user will be redirected to.')
        ],
        [
            'name' => 'language[index][key]',
            'type' => 0,
            'format' => 'string',
            'description' => __('The code of the targeted language.') . ' ' . __('The code must be in :standard standard.', ['standard' => '<a href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" target="_blank" rel="nofollow">ISO 639-1 alpha-2</a>'])
        ],
        [
            'name' => 'language[index][value]',
            'type' => 0,
            'format' => 'string',
            'description' => __('The link where the user will be redirected to.')
        ],
        [
            'name' => 'rotation[index][value]',
            'type' => 0,
            'format' => 'string',
            'description' => __('The link where the user will be redirected to.')
        ]
    ];
@endphp

@include('developers.parameters')