<?php

namespace App\Providers;

use App\Interfaces\ClientInterface;
use App\Repositories\ClientRepository;
use Illuminate\Support\ServiceProvider;

class ClientProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(ClientInterface::class, ClientRepository:: class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
