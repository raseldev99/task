<?php

namespace App\Http\Controllers\Admin;

use App\Enum\Role;
use App\Enum\Status;
use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\User;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
	{
		$users = User::where('status',Status::DEFAULT->value)->where('role',Role::USER->value)->paginate(20);
		return view('admin.dashboard',compact('users'));
	}
	
	
	public function approved(User $user)
	{
	    $user->update(['status'=>Status::APPROVED->value]);
		flash()->addSuccess('Registration successfully approved.');
		return redirect()->back();
	}
	
	public function declined(User $user)
	{
		$user->update(['status'=>Status::DECLINED->value]);
		flash()->addSuccess('Registration successfully declined.');
		return redirect()->back();
	}
}
