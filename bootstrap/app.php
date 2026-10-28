<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 1. 註冊全域中間件（每次 HTTP 請求都會執行）
        $middleware->append(\App\Http\Middleware\SwitchDatabaseMiddleware::class);

        // 2. 加入到 web 中間件組 (對應舊版 Kernel.php 的 $middlewareGroups['web'])
        $middleware->web(append: [
            \App\Http\Middleware\CleanHtmlSource::class,
            \App\Http\Middleware\SetLfmPhotoPath::class,
        ]);

        // 3. 註冊路由別名 (對應舊版 Kernel.php 的 $routeMiddleware)
        $middleware->alias([
            'admin'      => \App\Http\Middleware\AdminMiddleware::class,
            'admin_exec' => \App\Http\Middleware\AdminExecMiddleware::class,
            'exec'       => \App\Http\Middleware\ExecMiddleware::class,
            'local'      => \App\Http\Middleware\LocalMiddleware::class,            
            'dns_admin'  => \App\Http\Middleware\DnsAdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
