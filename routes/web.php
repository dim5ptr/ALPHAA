<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->middleware('guest')
            ->name('password.request');

Route::put('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->middleware('guest')
            ->name('password.email');

// Password Reset Routes...
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->middleware('guest')
            ->name('password.reset');

Route::put('reset-password', [NewPasswordController::class, 'store'])
            ->middleware('guest')
            ->name('password.update');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::redirect('/', '/login');

Route::get('/login', [PagesController::class, 'loginPage'])->name('login');

Route::post('/login', [UserController::class, 'login'])->name('user.login');

Route::get('/register', [PagesController::class, 'registerPage'])->name('register');

Route::post('/register', [UserController::class, 'register'])->name('user.register');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [PagesController::class, 'dashboardPage'])->name('dashboard');
});

Route::put('/profil/update/{id}', [UserController::class, 'update'])->name('profile.update');


Route::get('/profil', [PagesController::class, 'profilPage'])->name('profil');

Route::get('/tes_pkl', [PagesController::class, 'tesPKL'])->name('tes_pkl');

Route::patch('/data-user/{id}', [UserController::class, 'update'])->name('DataUser.update');

Route::get('/about', [PagesController::class, 'aboutPage'])->name('about');
