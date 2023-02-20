<?php

namespace Corals\Modules\Payment\Coinbase;

use Illuminate\Support\ServiceProvider;
use Corals\Settings\Facades\Modules;

class CoinbaseServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerModulesPackages();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/payment-coinbase');
    }
}
