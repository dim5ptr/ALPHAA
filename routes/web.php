<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;

// Email Verification Route
//Route::get('email/verify/{id}/{hash}', [UserController::class, 'verifyEmail'])->name('verification.verify');

// Authentication Routes
require __DIR__.'/auth.php';

// Homepage Redirect
Route::redirect('/', '/login');

// Login Routes
Route::get('/login', [PagesController::class, 'loginPage'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('user.login');

// Register Routes
Route::get('/register', [PagesController::class, 'registerPage'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('user.register');
Route::get('/register/confirmation', function () {
    return view('public.register-confirmation');
})->name('register.confirmation');

// Authenticated Routes
Route::middleware(['api'])->group(function () {
    Route::get('/dashboard', [PagesController::class, 'dashboardPage'])->name('dashboard');
    Route::get('/profil', [PagesController::class, 'profilPage'])->name('profil');
    Route::put('/profil/update/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::get('/tes_pkl', [PagesController::class, 'tesPKL'])->name('tes_pkl');
    Route::patch('/data-user/{id}', [UserController::class, 'update'])->name('DataUser.update');
    Route::get('/about', [PagesController::class, 'aboutPage'])->name('about');
 });
