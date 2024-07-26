<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'address' => session('address'),
            'image' => session('image'),
        ];
        // dd(session()->all());
        // dd($personalInfo);
        return view('view.profil', compact('personalInfo'));

    }
    public function dashboardPage()
    {
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
}
