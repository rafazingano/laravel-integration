<?php

namespace ConfrariaWeb\Integration\Providers;

use ConfrariaWeb\Integration\Contracts\IntegrationContract;
use ConfrariaWeb\Integration\Contracts\IntegrationTypeContract;
use ConfrariaWeb\Integration\Repositories\IntegrationRepository;
use ConfrariaWeb\Integration\Repositories\IntegrationTypeRepository;
use ConfrariaWeb\Integration\Services\IntegrationService;
use ConfrariaWeb\Integration\Services\IntegrationTypeService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use MeridienClube\Meridien\Services\Integrations\JsonGuntherService;
use MeridienClube\Meridien\Services\Integrations\JsonService;
use MeridienClube\Meridien\Services\Integrations\RdStationService;

class IntegrationServiceProvider extends ServiceProvider
{

    protected $commands = [
        'ConfrariaWeb\Integration\Commands\Integration',
    ];

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Databases/Migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../Translations', 'integration');
        $this->loadViewsFrom(__DIR__ . '/../Views', 'integration');
        $this->publishes([__DIR__ . '/../../config/cw_integration.php' => config_path('cw_integration.php')], 'cw_integration');

        Blade::component('integration::components.integrations', 'integrations');
    }

    public function register()
    {
        $this->commands($this->commands);

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
