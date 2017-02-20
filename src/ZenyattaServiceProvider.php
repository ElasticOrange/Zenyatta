<?php

namespace ElasticOrange\Zenyatta;

use Illuminate\Support\ServiceProvider;

class ZenyattaServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/zenyatta.php' => config_path('zenyatta.php')
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
