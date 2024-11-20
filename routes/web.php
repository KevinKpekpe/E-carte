<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Clients\ClassiqueController;
use App\Http\Controllers\Clients\PremiumController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Routes protégées pour les utilisateurs classiques
Route::middleware(['auth', 'user.type:classique','verified'])->group(function () {
    Route::view('/classique', 'clients.classique.index')->name('client.index');
});

Route::middleware(['auth', 'user.type:premium', 'verified'])->group(function () {
    Route::view('/premium', 'clients.premium.index')->name('premium.index');
});

Route::get('/register/classique', [ClassiqueController::class, 'create']);
Route::post('/register/classique', [ClassiqueController::class, 'register'])->name('register.classique');

Route::get('/register/premium', [PremiumController::class, 'create']);
Route::post('/register/premium', [PremiumController::class, 'register'])->name('register.premium');


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('/bye', function () {
    return view('auth.logout');
})->name('logout.vue');
Route::middleware(['auth'])->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});


Route::get('/verify-email/{token}', [ClassiqueController::class, 'verifyEmail'])
    ->name('verify.email');
Route::get('/email/verify', function () {
    return view('auth.verification-notice');
})->middleware('auth')->name('verification.notice');
Route::post('/email/resend-verification', [ClassiqueController::class, 'resendVerification'])
    ->name('verification.resend')->middleware('throttle');
