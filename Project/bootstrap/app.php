<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\Authenticate::class, // Protéger les routes avec auth
        ]);
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // $schedule->command('abonnement:update-status')->daily();
        // $schedule->command('abonnement:update-status')->hourly();
        // $schedule->command('abonnement:update-status')->everyMinute();
        $schedule->command('abonnement:update-status')->everyFiveSeconds();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
