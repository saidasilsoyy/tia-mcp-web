<?php

use App\Console\Commands\AdminAuditPruneCommand;
use App\Console\Commands\SecurityHealthCommand;
use App\Http\Middleware\Admin\EnsureAdmin;
use App\Http\Middleware\Security\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withCommands([
        AdminAuditPruneCommand::class,
        SecurityHealthCommand::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('web', SecurityHeaders::class);
        $middleware->redirectGuestsTo(fn (): string => route('auth.login'));
        $middleware->alias([
            'admin' => EnsureAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
