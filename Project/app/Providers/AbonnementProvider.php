<?php

namespace App\Providers;

use App\Interfaces\AbonnementInterface;
use Illuminate\Support\ServiceProvider;

class AbonnementProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(AbonnementInterface::class, AbonnementProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
