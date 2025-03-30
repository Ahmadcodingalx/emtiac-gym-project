<?php

namespace App\Providers;

use App\Interfaces\TransactionInterface;
use App\Repositories\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class TransactionProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
