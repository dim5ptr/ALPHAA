<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class PagesController extends Controller
{
    public function loginPage()
    {
        return view("public.login");
    }
    public function AloginPage()
    {
        return view("public.admin_login");
    }
    public function registerPage()
    {
        return view("public.register");
    }
    public function AregisterPage()
    {
        return view("public.admin_regis");
    }
    public function profilPage()
    {
        $personalInfo = [

            'fullname' => session('full_name'),
            'username' => session('username'),
            'birthday' => session('birthday'),
            'gender' => session('gender'),
            'email' => session('email'),
            'phone' => session('phone'),
            'profile_picture' => session('profile_picture'),
        ];
        // dd(session()->all());
        // dd($personalInfo);
        return view('view.profil', compact('personalInfo'));

    }
    public function dashboardPage()
    {
        $accessToken = Session::get('access_token');

    // Debugging: Tampilkan token untuk memastikan apakah token ada
    if (!$accessToken) {
        return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
    }

    // Tambahkan debugging untuk memastikan token berhasil diambil
    Log::info('Access Token: ' . $accessToken);

    return view("view.dashboard");
    }
    public function AdashboardPage()
    {
        return view("view.admin_dashboard");
    }
    public function tesPKL()
    {
        return view("view.tes_pkl");
    }

    public function aboutPage()
    {
        return view("view.about");
    }

    public function emailVerifyNotice()
    {
        return view('auth.verify-email');
    }
    public function showChangePasswordForm()
    {
        return view('view.security'); // Pastikan ini sesuai dengan nama tampilan Anda
    }

    public function PesanPw()
    {
        return view("view.pw-confirm");
    }
}
