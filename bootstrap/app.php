<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\RemoveUnwantedQuery;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
  
    ->withMiddleware(function (Middleware $middleware): void {
        // API stays stateless; the web group gets sessions + locale handling.
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
$middleware->append(RemoveUnwantedQuery::class);
        // The `lng` locale cookie is a plain, non-sensitive value read by
        // SetLocale before decryption — keep it unencrypted.
        $middleware->encryptCookies(except: ['lng']);

        // Guard for the server-rendered admin panel (session token via AdminAuth).
        $middleware->alias([
            'admin.web' => \App\Http\Middleware\AdminWebAuth::class,
        ]);
    })
      ->withExceptions(function (Exceptions $exceptions): void {
        //

             $exceptions->render(function (
            NotFoundHttpException $exception,
            Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'This page has been permanently removed.',
                ], 410);
            }

            return response()->view('errors.410', [], 410);
        });
    })->create();

    // ->withExceptions(function (Exceptions $exceptions): void {
    //     // Return JSON for all API exceptions
    //     $exceptions->render(function (\Throwable $e, Request $request) {
    //         if ($request->is('api/*') || $request->expectsJson()) {
    //             if ($e instanceof \Illuminate\Validation\ValidationException) {
    //                 return response()->json([
    //                     'error'  => $e->getMessage(),
    //                     'errors' => $e->errors(),
    //                 ], 422);
    //             }
    //             if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
    //                 return response()->json(['error' => 'Not found.'], 410);
    //             }
    //             if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
    //                 return response()->json(['error' => 'Method not allowed.'], 410);
    //             }
    //             if ($e instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException) {
    //                 return response()->json(['error' => 'Too many requests. Please try again shortly.'], 429);
    //             }
    //         }
    //         return null;
    //     });
    // })->create();
