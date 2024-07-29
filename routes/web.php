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
Route::get('/Alogin', [PagesController::class, 'AloginPage'])->name('Alogin');
Route::post('/Alogin', [UserController::class, 'Alogin'])->name('admin.login');

// Register Routes
Route::get('/register', [PagesController::class, 'registerPage'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('user.register');
Route::get('/register/confirmation', function () {
    return view('public.register-confirmation');
})->name('register-confirmation');
Route::get('/Aregister', [PagesController::class, 'AregisterPage'])->name('Aregister');
Route::post('/Aregister', [UserController::class, 'Aregister'])->name('admin.register');
Route::get('/Aregister/confirmation', function () {
    return view('public.register-confirmation');
})->name('Aregister.confirmation');
// Authenticated Routes
Route::middleware(['api'])->group(function () {
    Route::get('/dashboard', [PagesController::class, 'dashboardPage'])->name('dashboard');
    Route::get('/profil', [PagesController::class, 'profilPage'])->name('profil');
    Route::post('/update-profile', [UserController::class, 'updatePersonalInfo'])->name('updatePersonalInfo');
    Route::post('/update-profile-picture', [UserController::class, 'updateProfilePicture'])->name('upload.profile.picture');
    Route::get('/tes_pkl', [PagesController::class, 'tesPKL'])->name('tes_pkl');
    Route::patch('/update-profile-picture', [UserController::class, 'updateProfilePicture'])->name('profilePicture.update');
    Route::patch('/update-personal-info', [UserController::class, 'updatePersonalInfo'])->name('personalInfo.update');
    Route::get('/about', [PagesController::class, 'aboutPage'])->name('about');
    // Definisikan rute untuk menampilkan formulir perubahan kata sandi
Route::get('/change-password', [PagesController::class, 'showChangePasswordForm'])->name('change-password-form');

// Definisikan rute untuk menangani permintaan POST formulir perubahan kata sandi
Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password');
 });

 Route::middleware(['api'])->group(function () {
    Route::get('/Adashboard', [PagesController::class, 'AdashboardPage'])->name('Adashboard');
    // Route::get('/profil', [PagesController::class, 'profilPage'])->name('profil');
    // Route::get('/update-profile', [PagesController::class, 'showUpdateForm'])->name('showUpdateForm');
    // Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('updateProfile');
    // Route::post('/update-profile-picture', [UserController::class, 'updateProfilePicture'])->name('updateProfilePicture');
    // Route::get('/tes_pkl', [PagesController::class, 'tesPKL'])->name('tes_pkl');
    // Route::patch('/data-user/{id}', [UserController::class, 'update'])->name('DataUser.update');
    // Route::get('/about', [PagesController::class, 'aboutPage'])->name('about');
 });

 Route::post('/logout', [UserController::class, 'logout'])->middleware('api')->name('logout');
