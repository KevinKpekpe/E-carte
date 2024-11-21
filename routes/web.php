<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Clients\ClassiqueController;
use App\Http\Controllers\Clients\PremiumController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
})->middleware('guest');


// Routes protégées pour les utilisateurs classiques
Route::middleware(['auth', 'user.type:classique','verified'])->group(function () {
    Route::view('/classique', 'clients.classique.index')->name('client.index');
});

Route::middleware(['auth', 'user.type:premium', 'verified'])->group(function () {
    Route::view('/premium', 'clients.premium.index')->name('premium.index');
    Route::view('/premium/edit', 'clients.premium.edit')->name('premium.edit');
    Route::view('/premium/change', 'clients.premium.change-password')->name('premium.change');
    Route::put('/premium/update',[PremiumController::class,'update'])->name('premium.update');
    Route::put('/premium/update-password', [PremiumController::class, 'updatePassword'])
    ->name('premium.update-password');
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
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});


Route::get('/verify-email/{token}', [ClassiqueController::class, 'verifyEmail'])
    ->name('verify.email');
Route::get('/email/verify', function () {
    return view('auth.verification-notice');
})->middleware('auth')->name('verification.notice');
Route::post('/email/resend-verification', [ClassiqueController::class, 'resendVerification'])
    ->name('verification.resend')->middleware('throttle');

// Routes admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'user.type:superadmin'])->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/deactivate', [UserController::class, 'deactivateAccount'])->name('users.deactivate');
    Route::post('/users/{id}/send-activation', [UserController::class, 'sendActivationLink'])->name('users.send-activation');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});
Route::get('/users/activate/{token}', [UserController::class, 'activateAccount'])->name('users.activate');


