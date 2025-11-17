<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'agen' => \App\Http\Middleware\AgenMiddleware::class,
            'petani' => \App\Http\Middleware\PetaniMiddleware::class,
            'supir' => \App\Http\Middleware\SupirMiddleware::class,
            'otp.verified' => \App\Http\Middleware\EnsureOtpIsVerified::class,
            'anyauth' => \App\Http\Middleware\AnyAuth::class,
            'trusted.device' => \App\Http\Middleware\CheckTrustedDevice::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();