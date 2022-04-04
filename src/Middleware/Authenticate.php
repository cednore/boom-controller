<?php

namespace Boom\Middleware;

use Closure;

use Boom\Exceptions\AppAuthException;


/**
 * Middleware for authentication.
 */
class Authenticate {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Boom\Exceptions\AppException
     */
    public function handle($request, Closure $next) {
        $token = config('boom.app.auth.token');
        if ($token && $request->header('Authorization') != "Bearer $token") {
            throw new AppAuthException;
        }

        return $next($request);
    }
}
