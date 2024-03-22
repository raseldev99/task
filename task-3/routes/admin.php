<?php
	
	use App\Http\Controllers\Admin\Dashboard;
	use Illuminate\Support\Facades\Route;
	
	Route::get('/dashboard',[Dashboard::class,'index']);
	Route::post('/approved/{user}',[Dashboard::class,'approved'])->name('admin.approved');
	Route::post('/declined/{user}',[Dashboard::class,'declined'])->name('admin.declined');
	
	
	
	