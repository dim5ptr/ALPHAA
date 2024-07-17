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
            background-color: #d5def7;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif; /* Ganti dengan font yang Anda inginkan */
        }

        ::-webkit-scrollbar {
            width: 0px;
        }

        .text-bg-dark {
            color: #000000;
        }

        .btn-primary, .btn-light, .btn-danger {
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            border: none;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-light {
            background-color: #f8f9fa;
            color: black;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 0.3rem;
            margin: 10px auto;
            width: 80%;
            max-width: 600px;
            padding: 20px;
        }

        .modal-header {
            background-color: #d5def7;
            color: #000000;
            border-bottom: none;
            padding: 15px;
        }

        .modal-body {
            background-color: #f8f9fa;
            color: #000000;
            text-align: left;
            padding: 15px;
        }

        .modal-footer {
            background-color: #f8f9fa;
            border-top: none;
            padding: 15px;
            text-align: right;
        }

        .alert {
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid transparent;
            border-radius: 4px;
            text-align: left;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }

        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .container-flex {
            display: flex;
            flex-direction: wrap;
            padding: 20px;
            width:  80%;
            max-width: 100%;
            background-color: white;
            margin-left: 10%;
            margin-top: 2%;
            border-radius: 20px;
        }

.pict {
    flex-basis: 150px; /* adjust the width of the image */
    margin-right: 20px; /* add some space between the image and the data */
}

.data {
    flex: 1; /* take up the remaining space */
}

        .rounded {
            border-radius: 50%;
        }

        .shadow-md {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .text-left {
            text-align: left;
        }

        .text-black {
            color: black;
        }

        .p-2 {
            padding: 10px;
        }

        .p-3 {
            padding: 20px;
        }

        .pb-3 {
            padding-bottom: 20px;
        }

        .pt-3 {
            padding-top: 20px;
        }

        .m-2 {
            margin: 10px;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .me-2 {
            margin-right: 10px;
        }
    </style>
@endsection

@section('main')
    @include('layouts.navigation')
    <div class="container-flex pt-3 pb-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" onclick="closeAlert(this)">Close</button>
            </div>
        @elseif (session('updated'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('updated') }}
                <button type="button" class="btn-close" onclick="closeAlert(this)">Close</button>
            </div>
        @elseif (session('deleted'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('deleted') }}
                <button type="button" class="btn-close" onclick="closeAlert(this)">Close</button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="btn-close" onclick="closeAlert(this)">Close</button>
            </div>
        @endif
        <div class="container grid grid-cols-2 gap-4">
            <div class="pict">
                @if ($user->user_profil_url === '' || $user->user_profil_url === null)
                    <img width="150px" height="150px" src="{{ asset('img/user.png') }}"
                        class="rounded m-2 d-block shadow-md" alt="...">
                @else
                    <img width="150px" height="150px"
                        src="{{ asset('storage/user/profile/' . basename($user->user_profil_url)) }}"
                        class="rounded m-2 d-block shadow-md" alt="...">
                @endif
            </div>
            <div class="data">
                <h3 class="text-black">{{ $user->user_fullname }} - {{ $user->user_username }}</h3>
                <h5 class="text-black">{{ $user->user_alamat }} | {{ $user->user_notelp }}</h5>
                <p class="text-black">{{ $user->user_email }}</p>
                <button type="button" class="btn btn-dark" onclick="openModal()">
                    <i class="fas fa-user-edit me-2"></i>Update Profil
                </button>
            </div>
        </div>
        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-dark">
                    Logout
                </button>
            </form>
        </div>
            <div class="modal" id="updateUserModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateUserModalLabel">Ubah Profil</h1>
                        <button type="button" class="btn-close" onclick="closeModal()"></button>
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
                                    placeholder="Masukkan Username User" value="{{ $user->user_username }}" />
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
                                    placeholder="Masukkan No. Telp User" value="{{ $user->user_notelp }}" />
                            </div>
                            <div class="col-md-6">
                                <label for="alamat" class="form-label">Alamat User</label>
                                <input type="text" name="alamat" class="form-control" id="alamat"
                                    placeholder="Masukkan Alamat User" value="{{ $user->user_alamat }}" />
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" name="level" class="form-control" id="level"
                                    value="{{ $user->user_level }}" />
                                <input type="hidden" name="status" class="form-control" id="status"
                                    value="{{ $user->user_status }}" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function openModal() {
        document.getElementById('updateUserModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('updateUserModal').style.display = 'none';
    }

    function closeAlert(button) {
        var alert = button.parentElement;
        alert.style.display = 'none';
    }
</script>
