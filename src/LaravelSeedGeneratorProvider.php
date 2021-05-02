<?php
namespace LaravelSeedGenerator;

use Illuminate\Support\ServiceProvider;
use LaravelSeedGenerator\Commands\GenerateSeedsCommand;

class LaravelSeedGeneratorProvider extends ServiceProvider {
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-seed-generator.php',
            'laravel-seed-generator'
        );

        $this->publishes([
            __DIR__ . '/../stubs' => resource_path('stubs/vendor/laravel-seed-generator'),
            __DIR__ . '/../config/laravel-seed-generator.php' => config_path('laravel-seed-generator.php')
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateSeedsCommand::class
            ]);
        }
    }
}