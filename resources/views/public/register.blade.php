@extends('layouts.app')

@section('title', 'Register - Web Pendaftaran PKL')

@section('icon', 'img/logo_sarastya.png')

@section('header')
<style>
    body {
        background-color: #e8f0ff; /* Ubah warna latar belakang */
        opacity: 1;
    }

    .logo-container {
        display: flex;
        justify-content: center;
    }

    .img-logo {
        max-width: 200px;
        animation: fadeInUp 2s ease;
        margin: 20px auto; /* Membuat logo berada di tengah */
    }

    .btn-primary {
        background-color: #007bff; /* Warna biru */
        border-color: #007bff; /* Warna border biru */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Warna biru tua saat dihover */
        border-color: #0056b3; /* Warna border biru tua saat dihover */
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
<section class="pt-4 container">
    <div class="card shadow-lg">
        <div class="card-header logo-container"> <!-- Tambahkan kelas logo-container di sini -->
            <img src="{{ asset('img/logo_sarastya.png') }}" alt="img-logo" class="img-logo" loading="lazy" />
        </div>
        <div class="card-body container-fluid px-4 pt-4">
            <form class="row g-3 needs-validation" action="{{ route('user.register') }}" method="post">
                @csrf
                <div class="form-label col-md-6">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                            class="form-control" placeholder="Masukkan username Anda" required />
                    </div>
                    @error('username')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                    <div class="form-label col-md-6">
                        <label for="alamat" class="form-label">Alamat</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-geo-alt-fill"></i>
                            </span>
                            <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}"
                                class="form-control" placeholder="Masukkan alamat Anda" required />
                        </div>
                        @error('alamat')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-label col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope-fill"></i>
                            </span>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="form-control" placeholder="Masukkan email Anda" required />
                        </div>
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-label col-md-6">
                        <label for="notelp" class="form-label">No. Telp</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-telephone-fill"></i>
                            </span>
                            <input type="tel" name="notelp" id="notelp" value="{{ old('notelp') }}"
                                class="form-control" placeholder="Masukkan nomor telepon Anda" required />
                        </div>
                        @error('notelp')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-label col-md-6 my-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-key-fill"></i>
                            </span>
                            <input type="password" name="password" id="password" value="{{ old('password') }}"
                                class="form-control" placeholder="Masukkan password Anda" required />
                        </div>
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-label col-md-6 my-3">
                        <label for="password" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-key-fill"></i>
                            </span>
                            <input type="password" name="valid_password" id="valid_password"
                                value="{{ old('valid_password') }}"class="form-control"
                                placeholder="Konfirmasi password Anda" required />
                        </div>
                        @error('valid_password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit">Register</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <a href="{{ route('login') }}" class="link-underline link-underline-opacity-0">
                    <p class="text-center" style="color: #8423ff;">
                        Sudah punya akun? Silahkan masuk
                    </p>
                </a>
            </div>
        </div>
    </section>
@endsection
