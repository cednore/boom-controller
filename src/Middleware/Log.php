<?php

namespace Boom\Middleware;

use Closure;


/**
 * Middleware for logging reported events.
 */
class Log {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        // TODO:
        return $next($request);
    }
}
