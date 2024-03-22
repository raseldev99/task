<?php

namespace App\Http\Middleware;

use App\Enum\Role;
use App\Enum\Status;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		if (Auth::user()->role === Role::ADMIN->value){
			return  redirect('/admin/dashboard');
		}
		if (Auth::user()->role === Role::USER->value && Auth::user()->status !== Status::APPROVED->value){
			return $next($request);
		}
		
		return redirect('/');
		
    }
}
