<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use Laravel\Socialite\Facades\Socialite;



Route::get('/test',[TestController::class,'test']);

Route::get('/login',[AuthController::class,'login']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registering'])->name('registering');
Route::get('/', function () {
    return view('layout.master');
});
Route::get('/auth/redirect/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->name('auth.redirect');

Route::get('/auth/callback/{provider}', [AuthController::class, 'callback'])->name('auth.callback');


Route::get('/', function () {
    return view('layout.master');
})->name('welcome');