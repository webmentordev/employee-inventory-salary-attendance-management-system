<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\DesignationController;



Route::post('/login', [LoginController::class, 'store']);
Route::post('/employee', [DesignationController::class, 'employee']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('users', UserController::class);
    Route::resource('designations', DesignationController::class);
    Route::post('/logout', [LogoutController::class, 'store']);
});



Route::get('/attendance', function(){
    return User::with('attendance')->where('status', 'active')->get();
});

Route::get('/breaks', function(){
    return User::with('break')->get();
});


Route::get('/salary', function(){
    return User::with('salary')->get();
});