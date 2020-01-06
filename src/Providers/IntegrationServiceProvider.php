<?php

namespace ConfrariaWeb\Integration\Providers;

use ConfrariaWeb\Integration\Contracts\IntegrationContract;
use ConfrariaWeb\Integration\Contracts\IntegrationTypeContract;
use ConfrariaWeb\Integration\Repositories\IntegrationRepository;
use ConfrariaWeb\Integration\Repositories\IntegrationTypeRepository;
use ConfrariaWeb\Integration\Services\IntegrationService;
use ConfrariaWeb\Integration\Services\IntegrationTypeService;
use Illuminate\Support\ServiceProvider;

class IntegrationServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Views', 'integration');
    }

    public function register()
    {
        $this->app->bind(IntegrationTypeContract::class, IntegrationTypeRepository::class);
        $this->app->bind('IntegrationTypeService', function ($app) {
            return new IntegrationTypeService($app->make(IntegrationTypeContract::class));
        });

        $this->app->bind(IntegrationContract::class, IntegrationRepository::class);
        $this->app->bind('IntegrationService', function ($app) {
            return new IntegrationService($app->make(IntegrationContract::class));
        });
    }

}
