<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SubuserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('components.login');
});
// Public
// Route::get('/', function () {
//     return view('home');
// });

// Auth
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [LogController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LogController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// Email verification
Route::get('/email/verify', function () {
    return view('components.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth'])->name('dashboard');

// Superuser only: manage subusers
Route::middleware(['auth',  'superuser'])->group(function () {
    Route::resource('subuser', SubuserController::class)->except(['destroy']);
    Route::patch('/subuser/{subuser}/activate', [SubuserController::class, 'activate'])
        ->name('subuser.activate');
    Route::delete('/subuser/{subuser}', [SubuserController::class, 'destroy'])
        ->name('subuser.destroy');
});
