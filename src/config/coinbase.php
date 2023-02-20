<?php

return [
    'name' => 'Coinbase',
    'key' => 'payment_coinbase',
    'support_subscription' => true,
    'support_ecommerce' => true,
    'manage_remote_plan' => false,
    'create_remote_customer' => false,
    'capture_payment_method' => true,
    'require_default_payment_set' => true,
    'supports_swap' => false,
    'can_update_payment' => true,
    'supports_swap_in_grace_period' => false,
    'require_invoice_creation' => false,
    'require_plan_activation' => false,
    'require_payment_token' => false,
    'subscription_self_managed' => true,
    'default_subscription_status' => 'pending',
    'charge_payment_default_status' => 'pending',
    
    'settings' => [
        'api_key' => [
            'label' => 'Coinbase::labels.settings.api_key',
            'type' => 'text',
            'required' => true,
        ],
        'secret' => [
            'label' => 'Coinbase::labels.settings.secret',
            'type' => 'text',
            'required' => true,
        ],
        'payment_instructions' => [
            'label' => 'Coinbase::labels.settings.payment_instructions',
            'type' => 'textarea',
            'required' => false,
        ],
    ],
    'events' => [
        'charge:confirmed' => \Corals\Modules\Payment\Coinbase\Job\HandleChargeConfirmed::class,
        'charge:resolved' => \Corals\Modules\Payment\Coinbase\Job\HandleChargeConfirmed::class,
    ],
    'webhook_handler' => \Corals\Modules\Payment\Coinbase\Gateway::class,
];
