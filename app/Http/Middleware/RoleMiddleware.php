<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     *
     * @throws HttpException
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // check role is exists
        if (! in_array($role, Roles::getValues())) {
            throw new HttpException(Response::HTTP_FORBIDDEN, 'Invalid role');
        }

        // authentication check
        if (! Auth::check()) {
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        // user role check give access or denied
        if (Auth::user()->role === $role) {
            return $next($request);
        }

        throw new HttpException(Response::HTTP_FORBIDDEN, 'Access denied');
    }
}
