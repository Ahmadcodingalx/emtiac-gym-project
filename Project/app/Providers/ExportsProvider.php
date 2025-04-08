<?php

namespace App\Providers;

use App\Interfaces\ExportsInterface;
use App\Repositories\ExportsRepository;
use Illuminate\Support\ServiceProvider;

class ExportsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(ExportsInterface::class, ExportsRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
