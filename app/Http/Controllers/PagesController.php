<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function loginPage()
    {
        return view("public.login");
    }

    public function registerPage()
    {
        return view("public.register");
    }

    public function profilPage()
    {
        $personalInfo = [
            'fullname' => session('full_name'),
            'username' => session('username'),
            'dateofbirth' => session('birthday'),
            'gender' => session('gender'),
            'email' => session('email'),
            'phone' => session('phone'),
        ];

        return view('view.profil', compact('personalInfo'));

    }
    public function showUpdateForm()
    {
        $personalInfo = [
            'fullname' => session('full_name'),
            'username' => session('username'),
            'dateofbirth' => session('birthday'),
            'gender' => session('gender'),
            'email' => session('email'),
            'phone' => session('phone'),
        ];

        return view('view.profil', compact('user'));

    }

    public function dashboardPage()
    {
        return view("view.dashboard");
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
}
