<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Services\SampleService;


class ExampleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SampleService::class, function($app) {
            return new SampleService();
        });

        $this->app->singleton(ExampleService::class, function($app) {
            return new ExampleService(
                $app->make(SampleService::class)
            );
        });
    }
}
