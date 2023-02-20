<?php

namespace Corals\Modules\Payment\Coinbase\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-payment-coinbase';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
