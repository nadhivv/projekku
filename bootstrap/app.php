<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Dosen;
use App\Http\Middleware\Mahasiswa;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'Dosen' => Dosen::class,
            'Admin' => Admin::class,
            'Mahasiswa' => Mahasiswa::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
