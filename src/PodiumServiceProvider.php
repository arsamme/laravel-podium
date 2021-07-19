<?php

namespace Arsam\LaravelPodium;

use Arsam\LaravelPodium\Client\PodiumClient;
use Illuminate\Support\ServiceProvider;

class PodiumServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/podium.php' => config_path('podium.php'),
        ], 'config');


        if ($this->isLumen()) {
            $this->app->configure('podium');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/podium.php', 'podium');

        $this->app->bind('podium', function () {
            return new PodiumClient;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['podium'];
    }

    /**
     * Check if app uses Lumen.
     *
     * @return bool
     */
    private function isLumen(): bool
    {
        return str_contains($this->app->version(), 'Lumen');
    }
}
