@extends('layouts.app')

@section('title', 'Login - Web Pendaftaran PKL')

@section('icon', 'img/logo_sarastya.png')

@section('header')
<style>
    body {
        background-color: #e8f0ff;
    }

    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        width: 400px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: auto;
        margin-bottom: auto;
        color: #000000; /* Warna teks putih */
    }

    .img-logo {
        max-width: 200px;
        animation: fadeInUp 2s ease;
        margin: 20px auto; /* Membuat logo berada di tengah */
    }

    .card-body {
        text-align: left; /* Membuat teks menjadi rata kiri */
    }

    .btn-primary {
        background-color: #007bff; /* Warna biru */
        border-color: #007bff; /* Warna border biru */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Warna biru tua saat dihover */
        border-color: #0056b3; /* Warna border biru tua saat dihover */
    }

    .card-footer {
        text-align: center;
    }

    .link-underline-opacity-0:hover {
        opacity: 0.7;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@section('main')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{session('success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
    </div>
@elseif ($errors->has('message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ $errors->first('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
@endif
<section class="login-container">
    <div class="card">
        <div class="card-header text-center"> <!-- Mengatur teks menjadi tengah -->
            <img src="{{ asset('img/logo_sarastya.png') }}" alt="img-logo" class="img-logo"/>
        </div>
        <div class="card-body">
            <form action="{{ route('user.login') }}" method="POST">
                @csrf
                <div class="form-group my-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <input type="text" name="username" id="username" class="form-control"
                            placeholder="Masukkan username Anda" required />
                    </div>
                </div>
                @error('username')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <div class="form-group my-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-key-fill"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan password Anda" required />
                    </div>
                </div>
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <div class="form-group my-3 d-grid">
                    <button class="btn btn-primary" type="submit">Login</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <a href="{{ route('register') }}" class="link-underline link-underline-opacity-0" style="color: #8423ff;">
                <p>Tidak punya akun? Silahkan mendaftar</p>
            </a>
        </div>
    </div>
</section>
@endsection
