<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::redirect('/', '/login');

Route::get('/login', [PagesController::class, 'loginPage'])->name('login');

Route::post('/login', [UserController::class, 'login'])->name('user.login');

Route::get('/register', [PagesController::class, 'registerPage'])->name('register');

Route::post('/register', [UserController::class, 'register'])->name('user.register');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [PagesController::class, 'dashboardPage'])->name('dashboard');
});

Route::get('/profil', [PagesController::class, 'profilPage'])->name('profil');

Route::get('/tes_pkl', [PagesController::class, 'tesPKL'])->name('tes_pkl');

Route::patch('/data-user/{id}', [UserController::class, 'update'])->name('DataUser.update');

Route::get('/about', [PagesController::class, 'aboutPage'])->name('about');
