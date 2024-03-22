<?php

namespace App\Http\Middleware;

use App\Enum\Role;
use App\Enum\Status;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		if (Auth::user()->role === Role::ADMIN->value){
			return $next($request);
		}
		if (Auth::user()->role === Role::USER->value && Auth::user()->status === Status::APPROVED->value){
			return $next($request);
		}
		if (Auth::user()->role === Role::USER->value && Auth::user()->status === Status::DECLINED->value){
			return redirect('/declined');
		}
		if (Auth::user()->role === Role::USER->value && Auth::user()->status === Status::DEFAULT->value){
			return redirect('/unapproved');
		}
		
		return redirect('/');
    }
}
