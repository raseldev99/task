<?php

namespace App\Http\Controllers;

use App\Enum\Role;
use App\Enum\Status;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
	public function index()
	{
		if (Auth::user()->role=== Role::ADMIN->value){
			return redirect('/admin/dashboard');
		}
		
		return view('dashboard');
	}
    public function unapproved()
	{
		if (Auth::user()->status !== Status::DEFAULT->value){
			return  redirect(RouteServiceProvider::HOME);
		}
		return view('/unapproved');
	}
	
	public function declined()
	{
		if (Auth::user()->status !== Status::DECLINED->value){
			return  redirect(RouteServiceProvider::HOME);
		}
		return view('/declined');
	}
}
