<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class PagesController extends Controller
{
    const API_URL='http://192.168.1.24:14041/api';
    const API_KEY='5af97cb7eed7a5a4cff3ed91698d2ffb';

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

    public function dashboardPage(Request $request)
    {
        // Check if the access token exists in the session
        if (!session()->has('access_token')) {
            // If not authenticated, redirect to the login page with an error message
            return redirect()->route('login')->with('error', 'Please log in to access the dashboard.');
        }

        // If authenticated, return the dashboard view with the access token
        return view('view.dashboard', [
            'access_token' => session('access_token'),
        ]);
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
