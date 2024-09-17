<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Database\QueryException;
use App\Http\Middleware\EnsureUserHasRole;
use App\Http\Middleware\EnsureUserIsConnected;
use Illuminate\Session\TokenMismatchException;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\ViteException;
use Illuminate\Http\Client\ConnectionException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => EnsureUserIsConnected::class,
            'guest' => RedirectIfAuthenticated::class,
            'role' => EnsureUserHasRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AccessDeniedHttpException $exception, Request $request) {
            return response()->view('errors.403', [], 403);
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            return response()->view('errors.404', [], 404);
        });

        $exceptions->render(function (TokenMismatchException $exception, Request $request) {
            return response()->view('errors.419', [], 419);
        });

        $exceptions->render(function (ConnectionException $exception, Request $request) {
            return response()->view('errors.500', [], 500);
        });

        $exceptions->render(function (HttpException $exception, Request $request) {
            return response()->view('errors.500', [], 500);
        });

        $exceptions->render(function (ViteException $exception, Request $request) {
            return response()->view('errors.500', [], 500);
        });

        $exceptions->render(function (ServiceUnavailableHttpException $exception, Request $request) {
            return response()->view('errors.503', [], 503);
        });

        $exceptions->render(function (QueryException $exception, Request $request) {
            if ($exception->getCode() === '23000') {
                return response()->view('errors.404', [], 400);
            } elseif ($exception->getCode() === 'HY000') {
                return response()->view('errors.504', [], 504);
            } else {
                return response()->view('errors.500', [], 500);
            }
        });
    })->create();
