<?php

// Author: Neeraj Saini
// Email: hax-neeraj@outlook.com
// GitHub: https://github.com/haxneeraj/
// LinkedIn: https://www.linkedin.com/in/hax-neeraj/

namespace Haxneeraj\LaravelAPIKit;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\RequestMakeCommand;

use Haxneeraj\LaravelAPIKit\Console\MakeRequestCommand;
use Haxneeraj\LaravelAPIKit\Console\MakeTransformerCommand;

class LaravelAPIKitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('command.make.request', function ($app) {
            return $app->make(MakeRequestCommand::class);
        });
        $this->app->singleton('command.make.transformer', function ($app) {
            return $app->make(MakeTransformerCommand::class);
        });

        $this->commands([
            'command.make.request',
            'command.make.transformer',
        ]);

    }

    public function boot(): void
    {
        $this->AddConfigFiles();
        $this->loadMessages();
    }

    private function AddConfigFiles(): void
    {
        // Register the publishable configuration file
        $this->publishes([
            __DIR__.'/../config/laravel-api-kit.php' => config_path('laravel-api-kit.php'),
        ], 'config');

        // Register the publishable translations
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/haxneeraj/laravel-api-kit/lang'),
        ], 'lang');
    }

    public function loadMessages(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'LaravelAPIKit');
    }
}

