<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Clients\ClassiqueController;
use App\Http\Controllers\Clients\EntrepriseController;
use App\Http\Controllers\Clients\PremiumController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\VerifyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
})->middleware('guest');


// Routes protégées pour les utilisateurs classiques
Route::middleware(['auth', 'user.type:classique','verified'])->group(function () {
    Route::view('/classique', 'clients.classique.index')->name('classique.index');
});

// Routes protégées pour les utilisateurs classiques
Route::prefix('entreprise')->name('entreprise.')->middleware(['auth', 'user.type:entreprise', 'verified'])->group(function () {
    Route::view('/', 'clients.entreprise.index')->name('index');
    Route::view('/change', 'clients.entreprise.change-password')->name('change');
    Route::view('/edit', 'clients.entreprise.edit')->name('edit');
    Route::put('/update', [EntrepriseController::class, 'update'])->name('update');
    Route::put('/update-password', [PasswordChangeController::class, 'updatePassword'])
    ->name('entreprise.update-password');
    Route::resource('employees', EmployeeController::class);
});

// Routes protégées pour les utilisateurs Premuim
Route::middleware(['auth', 'user.type:premium', 'verified'])->group(function () {
    Route::view('/premium', 'clients.premium.index')->name('premium.index');
    Route::view('/premium/edit', 'clients.premium.edit')->name('premium.edit');
    Route::view('/premium/change', 'clients.premium.change-password')->name('premium.change');
    Route::put('/premium/update',[PremiumController::class,'update'])->name('premium.update');
    Route::put('/premium/update-password', [PasswordChangeController::class, 'updatePassword'])
    ->name('premium.update-password');
});

// Routes protégées pour créer les Utilisateurs
Route::middleware('guest')->group(function () {
    Route::get('/register/classique', [ClassiqueController::class, 'create']);
    Route::post('/register/classique', [ClassiqueController::class, 'register'])->name('register.classique');

    Route::get('/register/premium', [PremiumController::class, 'create']);
    Route::post('/register/premium', [PremiumController::class, 'register'])->name('register.premium');

    Route::get('/register/entreprise/create', [EntrepriseController::class, 'create']);
    Route::post('/register/entreprise', [EntrepriseController::class, 'register'])->name('register.entreprise');
});


// Routes protégées pour l'authentication

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('/bye', function () {
        return view('auth.logout');
    })->name('logout.vue');
});
Route::middleware(['auth'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Route de verification d'email
Route::get('/verify-email/{token}', [VerifyController::class, 'verifyEmail'])
    ->name('verify.email');

Route::get('/email/verify', function () {
    return view('auth.verification-notice');
})->middleware('auth')->name('verification.notice');

Route::post('/email/resend-verification', [VerifyController::class, 'resendVerification'])
    ->name('verification.resend')->middleware('throttle');

// Routes admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'user.type:superadmin', 'lock.screen'])->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/deactivate', [UserController::class, 'deactivateAccount'])->name('users.deactivate');
    Route::post('/users/{id}/send-activation', [UserController::class, 'sendActivationLink'])->name('users.send-activation');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/profil',[ProfilController::class,'index'])->name('profil');
    Route::get('/profil/edit', [ProfilController::class,'edit'])->name('profil.edit');
    Route::put('/profil/update', [ProfilController::class,'update'])->name('profil.update');
});
Route::get('/users/activate/{token}', [UserController::class, 'activateAccount'])->name('users.activate');

// Routes de reinitialisation du mot de passe

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])
    ->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');



// Route pour afficher l'écran de verrouillage
Route::get('/lockscreen', [LoginController::class, 'show'])->name('lockscreen.show');
Route::post('/lockscreen/unlock', [LoginController::class, 'unlock'])->name('lockscreen.unlock');

