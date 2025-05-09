<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckOnboardingCompletion;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\InternMiddleware;
use App\Http\Middleware\MintorMiddleware;
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
            'admin' => AdminMiddleware::class,
            'mentor' => MintorMiddleware::class,
            'intern' => InternMiddleware::class,
            'check.onboarding' => CheckOnboardingCompletion::class,
            'web' => HandleInertiaRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $exception) {
            if (method_exists($exception, 'getStatusCode')) {
                $status = $exception->getStatusCode();
                if ($status === 403) {
                    return redirect()->route('error.403');
                } elseif ($status === 404) {
                    return redirect()->route('error.404');
                } elseif ($status === 500) {
                    return redirect()->route('error.500');
                }
            }
            return null;
        });
    })->create();
