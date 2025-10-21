<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth0Jwt
{
    public function handle(Request $request, Closure $next): Response
    {
        // TODO: validate RS256 via jwks; read permissions/roles from claims
        // For now passthrough (disabled by AUTH0_ENABLED=false)
        return $next($request);
    }
}
