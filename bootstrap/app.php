<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\PreventBackHistory;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Prevent browsers from serving cached pages on back/forward navigation
        $middleware->alias([
            'prevent-back-history' => PreventBackHistory::class,
        ]);

        // Apply to all web requests so login/register are not cached either
        $middleware->web(append: [PreventBackHistory::class]);

        // Redirect already-authenticated users away from guest pages
        $middleware->redirectUsersTo(fn () => route('dashboard'));
        // Redirect guests trying to access auth pages
        $middleware->redirectGuestsTo(fn () => route('login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
