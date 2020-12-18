<?php

namespace App\Providers;

use App\Repositories\Cache\UserRepository;
use App\Repositories\Database\UserRepository as DatabaseUserRepository;
use App\Repositories\External\Telemetry\MixpanelRepository;
use App\Services\User\CreateService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        // service # 1 : Create User Service
        $this->app->singleton(CreateService::class, function () {

            return new CreateService(
                new DatabaseUserRepository(),
                new UserRepository(),
                new MixpanelRepository()
            );
        });

         // service # 1 : Create User Service
        $this->app->bind(CreateService::class, function () {

            return new CreateService(
                new DatabaseUserRepository(),
                new UserRepository(),
                new MixpanelRepository()
            );
        });

        $this->app->make(CreateService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
