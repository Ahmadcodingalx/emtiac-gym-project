<?php

namespace App\Providers;

use App\Interfaces\CoursInterface;
use App\Repositories\CoursRepository;
use Illuminate\Support\ServiceProvider;

class CoursProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(CoursInterface::class, CoursRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
