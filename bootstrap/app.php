<?php

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
        $middleware->redirectGuestsTo(
            fn () => route('admin.login')
        );

        $middleware->append(
            \App\Http\Middleware\SecurityHeaders::class
        );

        $middleware->alias([
            'super_admin' => \App\Http\Middleware\EnsureIsSuperAdmin::class,
            'can_approve' => \App\Http\Middleware\EnsureCanApprove::class,
            'staf' => \App\Http\Middleware\EnsureIsStaf::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();