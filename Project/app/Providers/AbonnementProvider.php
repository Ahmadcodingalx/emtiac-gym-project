<?php

namespace App\Providers;

use App\Interfaces\AbonnementInterface;
use App\Repositories\AbonnementRepository;
use Illuminate\Support\ServiceProvider;

class AbonnementProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(AbonnementInterface::class, AbonnementRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
