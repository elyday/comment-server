<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 04.05.2018
 * Time: 09:58
 */

namespace App\Http\Middleware;


class CorsMiddleware
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
        $response->header('Access-Control-Allow-Origin', '*');
        return $response;
    }
}