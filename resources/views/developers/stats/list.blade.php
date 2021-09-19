@php
    $parameters = [
        [
            'name' => 'from',
            'type' => 1,
            'format' => 'string',
            'description' => __('The starting date in :format format.', ['format' => '<code>Y-m-d</code>'])
        ], [
            'name' => 'to',
            'type' => 1,
            'format' => 'string',
            'description' => __('The ending date in :format format.', ['format' => '<code>Y-m-d</code>'])
        ], [
            'name' => 'name',
            'type' => 1,
            'format' => 'string',
            'description' => __('The name of the statistic.') . ' ' . __('Possible values are: :values.', ['values' => '<code>'.implode('</code>, <code>', config('stats.types')).'</code>'])
        ], [
            'name' => 'search',
            'type' => 0,
            'format' => 'string',
            'description' => __('The search query.')
        ], [
            'name' => 'sort',
            'type' => 0,
            'format' => 'string',
            'description' => __('Sort') . '. ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>max</code>', 'name' => '<span class="font-weight-medium">'.__('Best performing').'</span>']),
                    __(':value for :name', ['value' => '<code>min</code>', 'name' => '<span class="font-weight-medium">'.__('Least performing').'</span>'])
                    ])
                ]).' ' . __('Defaults to: :value.', ['value' => '<code>max</code>'])
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