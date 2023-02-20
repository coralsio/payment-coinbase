<?php

namespace Corals\Modules\Payment\Coinbase\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function providerBooted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['Coinbase'] = 'Coinbase';

        \Payments::setAvailableGateways($supported_gateways);

        \DB::table('settings')->insert([
            [
                'code' => 'payment_coinbase_api_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_coinbase_api_key',
                'value' => 'bc888865-e69b-*********',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_coinbase_payment_instructions',
                'type' => 'TEXTAREA',
                'category' => 'Payment',
                'label' => 'payment_coinbase_payment_instructions',
                'value' => 'Coinbase Commerce integrates with a merchant\'s checkout workflow or can be added as a payment option on the shopping portal. Any cryptocurrency payment made by a customer gets credited to the merchant\'s Coinbase Commerce account from where it can be transferred to the desired wallet',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
