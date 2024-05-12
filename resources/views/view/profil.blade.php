@extends('layouts.app')

@auth
    @php
        $userRole = Auth::user()->user_level;
        $user = Auth::user();
    @endphp
@endauth

@section('title', 'Data Profil')

@section('header')
    <style>
        body {
            background-color: #007bff;
            width: 100vw;
            height: 100vh;
        }

        ::-webkit-scrollbar {
            width: 0px;
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

        .btn-light {
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .modal-header {
            background-color: #007bff;
            color: #fff;
            border-bottom: none;
        }

        .modal-body {
            background-color: #f8f9fa;
            color: #000000;
            text-align: left;
        }

        .modal-footer {
            background-color: #f8f9fa;
            border-top: none;
        }
    </style>
@endsection

@section('main')
    @include('layouts.navigation')
    <div class="container-flex text-center pt-3 pb-3" style="background: #007bff">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('updated'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('updated') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('deleted'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('deleted') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="text-bg-dark p-2">
            @auth
                @if ($user->user_profil_url === '' || $user->user_profil_url === null)
                    <img width="150px" height="150px" src="{{ asset('img/user.png') }}"
                        class="rounded m-2 mx-auto d-block shadow-md" alt="...">
                @else
                    <img width="150px" height="150px"
                        src="{{ asset('storage/user/profile/' . basename($user->user_profil_url)) }}"
                        class="rounded m-2 mx-auto d-block shadow-md" alt="...">
                @endif
                <h3 class="text-white">{{ $user->user_fullname }} - {{ $user->user_username }}</h3>
                <h5 class="text-white">{{ $user->user_alamat }} | {{ $user->user_notelp }}</h5>
                <p class="text-white">{{ $user->user_email }}</p>
                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#updateUserModal">
                    <i class="fas fa-user-edit me-2"></i>Update Profil
                </button>
            @endauth
            <div class="modal fade" data-bs-backdrop="static" id="updateUserModal" tabindex="-1"
                aria-labelledby="updateUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="updateUserModalLabel">Ubah
                                Profil</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('DataUser.update', ['id' => $user->id]) }}" method="post"
                            enctype="multipart/form-data">
                            <div class="modal-body row g-3">
                                @csrf
                                @method('PATCH')
                                <div class="d-grid">
                                    <label for="profil" class="form-label">Foto Profil</label>
                                    <input type="file" name="profil" class="form-control" id="profil"
                                        placeholder="Tambahkan Foto Profil" />
                                </div>
                                <div class="col-md-6">
                                    <label for="fullname" class="form-label">Nama User</label>
                                    <input type="text" name="fullname" class="form-control" id="nama"
                                        placeholder="Masukkan Nama User" value="{{ $user->user_fullname }}" />
                                </div>
                                <div class="col-md-6">
                                    <label for="username" class="form-label">Username User</label>
                                    <input type="text" name="username" class="form-control" id="username"
                                        placeholder="Masukkan Username User"
                                        value="{{ $user->user_username }}" />
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password User</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Masukkan Password User" value="{{ old('password') }}" />
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-mail User</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="Masukkan E-mail User" value="{{ $user->user_email }}" />
                                </div>
                                <div class="col-md-6">
                                    <label for="notelp" class="form-label">No. Telp User</label>
                                    <input type="number" name="notelp" class="form-control" id="notelp"
                                        placeholder="Masukkan No. Telp User"
                                        value="{{ $user->user_notelp }}" />
                                </div>
                                <div class="col-md-6">
                                    <label for="alamat" class="form-label">Alamat User</label>
                                    <input type="text" name="alamat" class="form-control" id="alamat"
                                        placeholder="Masukkan Alamat User" value="{{ $user->user_alamat }}" />
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="level" class="form-control" id="alamat"
                                        value="{{ $user->user_level }}" />
                                    <input type="hidden" name="status" class="form-control" id="alamat"
                                        value="{{ $user->user_status }}" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i
                                        class="fas fa-save me-2"></i>Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="p-1" style="background-color: #00008B;">
        <div class="card text-center" style="background: #00008B">
            <div class="card-header" style="background: #00008B">
            </div>
            <div class="card-body">
                <h5 class="card-title text-light">Web Pendaftaran PKL</h5>
                <p class="card-text text-light">Your Place for PKL Registration</p>
                <a href="tes_pkl" class="btn btn-primary">Start Registration</a>
            </div>
            <div class="card-footer text-light" style="background: #00008B">
                Copyright &copy; Web Pendaftaran PKL 2024
            </div>
        </div>
    </div>
@endsection
