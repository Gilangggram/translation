<?php

use App\Http\Middleware\OwnerMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'owner' => OwnerMiddleware::class,
        ]);
        
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('owner/*') || $request->is('kasir/*')) {
                return route('admin.login');
            } elseif ($request->is('stall/*')) {
                return route('stall.login');
            }
        });

        $middleware->redirectUsersTo(function ($request) {
            if (auth()->guard('admin')->check()) {
                return match(auth()->guard('admin')->user()->role) {
                    'owner'   => route('owner.dashboard'),
                    'cashier' => route('cashier.dashboard'),
                };
            } elseif ($request->is('/stall/login') && auth()->guard('stall')->check()) {
                return route('stall.dashboard');
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
