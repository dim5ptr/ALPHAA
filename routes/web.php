<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Password;

Route::get('email/verify/{id}/{hash}', 'UserController@verifyEmail')->name('verification.verify');

// Dashboard Route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

// Authenticated Routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [PagesController::class, 'dashboardPage'])->name('dashboard');
    Route::put('/profil/update/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::get('/profil', [PagesController::class, 'profilPage'])->name('profil');
    Route::get('/tes_pkl', [PagesController::class, 'tesPKL'])->name('tes_pkl');
    Route::patch('/data-user/{id}', [UserController::class, 'update'])->name('DataUser.update');
    Route::get('/about', [PagesController::class, 'aboutPage'])->name('about');
});
