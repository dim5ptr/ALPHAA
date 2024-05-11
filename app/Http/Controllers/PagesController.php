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
        return view("view.profil");
    }
    public function dashboardPage()
    {
        return view("view.dashboard");
    }
    public function tesPKL(){
        return view("view.tes_pkl");
    }
    public function aboutPage()
    {
        return view("view.about");
    }
}
