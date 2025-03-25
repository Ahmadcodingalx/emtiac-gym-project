<?php

namespace App\Providers;

use App\Interfaces\SaleInterface;
use App\Repositories\SaleRepository;
use Illuminate\Support\ServiceProvider;

class SaleProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(SaleInterface::class, SaleRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
