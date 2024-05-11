@extends('layouts.app')

@auth
    @php $userRole = Auth::user()->user_level; @endphp
@endauth

@section('title', 'Home')

@section('header')
    <style>
        body {
            background-color: #ffffff;
            width: 100vw;
            height: 100vh;
        }

        ::-webkit-scrollbar {
            width: 0px;
        }

        .text-light {
            color: #007bff;
        }

        .text-bg-dark {
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .card {
            background-color: #007bff;
        }
    </style>
@endsection

@section('main')
    @include('layouts.navigation')
    <section class="pt-2 container pb-5">
        <div class="card text-center border-2" style="background-color: #007bff;">
            <div class="card-body">
                <h2 class="card-title" style="color: #FFFFFF;">Selamat Datang di Sarastya Technology</h2>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <h1>Sarastya Technology Integrata (STI)</h1>
            </div>
            <div class="col-md-6">
                <p>Menyediakan layanan Pengembangan sistem/aplikasi (Process Automation) berbasis Business Process Model and Notation (BPMN) dan Enterprise Resources Planning (ERP) yang mengintegrasikan People, Process dan Technology di perusahaan.</p>
            </div>
        </div>
    </section>
@endsection


@section('footer')
    <div class="p-1" style="background-color: #00008B;">
        <div class="card text-center" style="background: #00008B">
            <div class="card-header" style="background: #00008B">
            </div>
            <div class="card-body">
                <h5 class="card-title text-light">Web Pendaftaran PKL</h5>
                <p class="card-text text-light">Your Place for PKL Registration</p>
                <a href="{{ route('about') }}" class="btn btn-primary">About Us</a>
            </div>
            <div class="card-footer text-light" style="background: #00008B">
                Copyright &copy; Web Pendaftaran PKL 2024
            </div>
        </div>
    </div>
@endsection
