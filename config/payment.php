<?php

return [
    'default_gateway' => env('PAYMENT_GATEWAY', 'stripe'),

    'gateways' => [
        'stripe' => [
            'enabled' => env('STRIPE_ENABLED', false),
            'public_key' => env('STRIPE_KEY'),
            'secret_key' => env('STRIPE_SECRET'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        ],
        'mercado_pago' => [
            'enabled' => env('MERCADO_PAGO_ENABLED', false),
            'public_key' => env('MERCADO_PAGO_PUBLIC_KEY'),
            'access_token' => env('MERCADO_PAGO_ACCESS_TOKEN'),
        ],
    ],

    'currency' => env('PAYMENT_CURRENCY', 'BRL'),
];
