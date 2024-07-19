<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Password;

Route::post('/verification/resend', [UserController::class, 'resend'])->name('verification.resend');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/verify-email', [UserController::class, 'showVerificationStatus'])->name('verify.email');
// Verifikasi email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $request->user()->markEmailAsVerified();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi email telah dikirim!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Password Reset Routes

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    // return view('auth.reset-password', ['token' => $token]);
    return 'berhasil kirim email notifikasi reset password';
})->middleware('guest')->name('password.reset');

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
