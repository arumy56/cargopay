<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', function() { 
//     return view('login'); 
// });

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/', [LogController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LogController::class, 'login']);

Route::get('/email/verify', function () {
    return view('components.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/dashboard', function () {
    return view('dashboard'); // This references your views/dashboard.blade.php file
})->middleware(['auth', 'verified'])->name('dashboard');
