<?php


namespace App\Http\Middleware;


use Closure;

class AbortJsonRequest
{

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->expectsJson()) {
            abort(404);
        }

        return $next($request);
    }
}