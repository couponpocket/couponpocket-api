<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateOptional extends Middleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param ...$guards
     * @return mixed|void
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if ($request->bearerToken()) {
            try {
                $this->authenticate($request, $guards);
            } catch (AuthenticationException $e) {
            }
        }

        return $next($request);
    }
}
