<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillerController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SubuserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubuserDashboardController;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('components.login');
});



// Auth
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::view('/terms-and-conditions', 'legal.terms')->name('terms');
Route::view('/privacy-policy', 'legal.privacy')->name('privacy');
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
})->middleware(['auth','superuser',  'active'])->name('dashboard.index');




// Superuser only: manage subusers
Route::middleware(['auth',  'active',  'superuser'])->group(function () {
    Route::resource('subuser', SubuserController::class)->except(['destroy']);
    Route::patch('/subuser/{subuser}/activate', [SubuserController::class, 'activate'])
        ->name('subuser.activate');
    Route::delete('/subuser/{subuser}', [SubuserController::class, 'destroy'])
        ->name('subuser.destroy');
     Route::post('/subuser/{subuser}/reset-password', [SubuserController::class, 'resetPassword'])
        ->name('subuser.reset-password');    
});
Route::get('subuser-dashboard', [SubuserDashboardController::class, 'index'])->middleware(['auth',  'active'])->name('subuser.dashboard');


Route::middleware(['auth', 'superuser'])->group(function () {
    // Biller Routes
    Route::get('/biller/create', [BillerController::class, 'create'])->name('biller.create');
    Route::post('/biller/store', [BillerController::class, 'store'])->name('biller.store');

    // Manage Organization (Role Assignment) Routes
   // Inside your auth middleware group
Route::get('/organization/roles', [SubuserController::class, 'manageRoles'])->name('subuser.organization');
Route::put('/organization/roles/{id}', [SubuserController::class, 'updateRole'])->name('subuser.updateRole');
});
