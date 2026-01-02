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
        
        // =================================================================
        // 1. DAFTAR ALIAS MIDDLEWARE
        // =================================================================
        // Menghubungkan 'role' dengan Logic RoleMiddleware
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);


        // =================================================================
        // 2. MATIKAN CSRF TOKEN KHUSUS MIDTRANS
        // =================================================================
        // Midtrans mengirim data POST dari server luar. 
        // Kita harus mengecualikan route ini dari pengecekan CSRF agar tidak Error 419.
        $middleware->validateCsrfTokens(except: [
            'midtrans-callback', // URL route callback midtrans
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();