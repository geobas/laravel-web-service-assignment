<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

/**
 * Profile a REST api with Laravel Debugbar.
 *
 * Render result as html instead of json.
 */
class DebugbarHtmlResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (
            $response instanceof JsonResponse &&
            app()->bound('debugbar') &&
            app('debugbar')->isEnabled()
        ) {
            $response->header('Content-Type', 'text/html');
        }

        return $response;
    }
}
