<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\JobPostingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('companies', CompanyController::class);
    Route::resource('job-postings', JobPostingController::class);
    Route::resource('candidates', CandidateController::class);
    Route::resource('applications', ApplicationController::class);
});