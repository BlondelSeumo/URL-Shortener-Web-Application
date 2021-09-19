<?php

return [
    'processors' => [
        'stripe' => [
            'name' => 'Stripe',
            'type' => 'Credit card'
        ],
        'paypal' => [
            'name' => 'PayPal',
            'type' => 'PayPal account'
        ],
        'coinbase' => [
            'name' => 'Coinbase',
            'type' => 'Cryptocurrency'
        ],
        'bank' => [
            'name' => 'Bank',
            'type' => 'Bank transfer'
        ]
    ]
];