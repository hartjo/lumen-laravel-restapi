<?php

namespace App\Http\Middleware;

use App\User;

use Closure;
use GenTux\Jwt\JwtToken;
use GenTux\Jwt\GetsJwtToken;
use GenTux\Jwt\Exceptions\NoTokenException;

class RoleMiddleware
{
    use GetsJwtToken;

    public function handle($request, Closure $next, $role)
    {
        if (!User::find($this->jwtPayload()['id'])->isRole($role)) {
            return response()->json(['error' => 'Permission Denied!'], 401);
        }
        return $next($request);
    }
}