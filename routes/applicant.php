<?php


use App\Http\Controllers\Applicant\HomePageController;
use Illuminate\Support\Facades\Route;

Route::get('/home', [HomePageController::class, 'index']);
