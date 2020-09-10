<?php

namespace Cherrypulp\LaravelActito;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/laravel-actito.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('laravel-actito.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'laravel-actito'
        );

        $this->app->bind('laravel-actito', function () {
            return new Actito([
                'base_uri' => config('laravel-actito.uri'),
                'version' => config('laravel-actito.version', 'v5'),
                'key' => config('laravel-actito.key')
            ]);
        });
    }
}
