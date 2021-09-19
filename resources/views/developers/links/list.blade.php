@php
    $parameters = [
        [
            'name' => 'search',
            'type' => 0,
            'format' => 'string',
            'description' => __('The search query.')
        ], [
            'name' => 'by',
            'type' => 0,
            'format' => 'string',
            'description' => __('Search by.') . ' ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>title</code>', 'name' => '<span class="font-weight-medium">'.__('Title').'</span>']),
                    __(':value for :name', ['value' => '<code>alias</code>', 'name' => '<span class="font-weight-medium">'.__('Alias').'</span>']),
                    __(':value for :name', ['value' => '<code>url</code>', 'name' => '<span class="font-weight-medium">'.__('URL').'</span>'])
                    ])
                ]) .' ' . __('Defaults to: :value.', ['value' => '<code>title</code>'])
        ], [
            'name' => 'status',
            'type' => 0,
            'format' => 'integer',
            'description' => __('Filter by status.') . ' ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>0</code>', 'name' => '<span class="font-weight-medium">'.__('All').'</span>']),
                    __(':value for :name', ['value' => '<code>1</code>', 'name' => '<span class="font-weight-medium">'.__('Active').'</span>']),
                    __(':value for :name', ['value' => '<code>2</code>', 'name' => '<span class="font-weight-medium">'.__('Expired').'</span>']),
                    __(':value for :name', ['value' => '<code>3</code>', 'name' => '<span class="font-weight-medium">'.__('Disabled').'</span>'])
                    ])
                ]) .' ' . __('Defaults to: :value.', ['value' => '<code>0</code>'])
        ], [
            'name' => 'space',
            'type' => 0,
            'format' => 'integer',
            'description' => __('Filter by space ID.')
        ], [
            'name' => 'domain',
            'type' => 0,
            'format' => 'integer',
            'description' => __('Filter by domain ID.')
        ], [
            'name' => 'pixel',
            'type' => 0,
            'format' => 'integer',
            'description' => __('Filter by pixel ID.')
        ], [
            'name' => 'sort',
            'type' => 0,
            'format' => 'string',
            'description' => __('Sort') . '. ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>desc</code>', 'name' => '<span class="font-weight-medium">'.__('Descending').'</span>']),
                    __(':value for :name', ['value' => '<code>asc</code>', 'name' => '<span class="font-weight-medium">'.__('Ascending').'</span>']),
                    __(':value for :name', ['value' => '<code>max</code>', 'name' => '<span class="font-weight-medium">'.__('Best performing').'</span>']),
                    __(':value for :name', ['value' => '<code>min</code>', 'name' => '<span class="font-weight-medium">'.__('Least performing').'</span>'])
                    ])
                ]) .' ' . __('Defaults to: :value.', ['value' => '<code>desc</code>'])
        ], [
            'name' => 'per_page',
            'type' => 0,
            'format' => 'int',
            'description' => __('Results per page') . '. '. __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':from to :to', ['from' => '<code>10</code>', 'to' => '<code>100</code>'])
                    ])
                ]) .' ' . __('Defaults to: :value.', ['value' => '<code>'.config('settings.paginate').'</code>'])
        ]
    ];
@endphp

@include('developers.parameters')