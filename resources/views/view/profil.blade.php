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
        font-family: Arial, sans-serif;
    }

    ::-webkit-scrollbar {
        width: 0px;
    }

    .text-bg-dark {
        color: #000000;
    }

    .btn-primary, .btn-dark, .btn-danger {
        padding: 8px 20px;
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
        padding: 10px 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin-top: 0px;
        cursor: pointer;
        border-radius: 4px;
        border: none;
        background-color: #365AC2;
        font-size: small;
        font-weight: bold;
        color: #d5def7;
    }

    .btn-dark {
        background-color: #bee5eb;
        color: #000000;
        font-weight: bold;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* General modal styling */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000; /* High z-index to ensure it's in front */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(134, 144, 176, 0.315); /* Black w/ opacity */
}

.modal-content {
    top: 10%;
    left: 15%;
    background-color: #fefefe;
    width:70%;
    height: 50%;
    display: flexbox;
    border-radius: 10px;
    position: relative;
}

.modal-header {
    background-color: #007bff;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e5e5e5;

}

.modal-header h1{
    color: white;
    font-weight: bolder;
}

.modal-title {
    margin: 0;
    font-size: 24px;
}

.btn-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
}

.edit{
    left: 0%;
    width: 100%;
    padding-right: 5%;
    padding-left: 5%;
    padding-bottom: 10px;
    border-radius: 10px;
    background-color: white;

}
/* Input fields */
.form-control {
    top: 2%;
    left: 2%;
    padding: 10px;
    margin-bottom: 15px;
    border: 2px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 14px; }

.form-control::after {
    border-color: #0056b3;
}

/* Labels */
.form-label {
top: 10%;
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    font-size: 14px;
}

/* Form rows */
.cf {
    margin-bottom: 15px;
}

.cl {
    display: flex;
    justify-content: space-between;
}

.cl > div {
    width: 48%;
}

/* Button */
.btn-primary {
    width: 40%%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #365AC2;
}

/* Modal footer */
.modal-footer {
    display: flex;
    justify-content: right;
    border-top: 1px solid #e5e5e5;
    padding-top: 10px;
    padding-bottom: 20px;
}

@media (max-width: 500px) {
    .cl {
        flex-direction: column;
    }

    .cl > div {
        width: 100%;
    }
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
        padding: 20px;
        width: 90%;
        height: 50%;;
        max-width: 100%;
        background-color: white;
        margin: 1.2% auto;
        border-radius: 20px;
        box-shadow: 0 4px 8px 4px rgba(0, 0, 0, 0.1); /* Add box shadow */
        justify-content: ;
        align-items: center;
    }

    .container-grid {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin: 2% auto;
    }

    .banner {
        top: 12px;
        width: 100%;
        height: 40%;
        max-width: 100%;
        background-color: #0056b3;
        margin: 0.5% auto;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        justify-content: space-between;
        align-items: center;
        font-weight: bolder;
        color: white;
    }

    .banner h4 {
        margin-left: 5%;
        padding-top: 4%;
        font-weight: 700;
        font-size: 30px;
    }

    .pict {
        flex-basis: 150px;
        margin-right: 20px;
    }

    .data {
        margin-top: 12px;
        margin-left: 20px;
        flex: 1;
    }

    .data span {
        font-size: 40px;
        margin-top: 0px;
        line-height: 45px;
        color: #000000;
    }

     p {
        font-size: 15px;
        line-height: 20px;
        color: rgb(92, 89, 89);
    }

    .rounded img {
        border-radius: 50px;
    }

    .text-left {
        text-align: left;
    }

    /* .text-black {
        color: black;
    } */

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


    .btn-container {
        left: 15%;
        justify-content: left;
        height: 20%%;
        width: 100%;
    }

    .btn-dark {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    form {
        position: absolute;
        top: 20%; /* Adjust as necessary */
        right: 9%; /* Adjust as necessary */
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
        <div class="banner">
            <h4>Akun Pengguna</h4>
            <form method="POST" action="{{ route('logout') }}" class="d-inline-block">
                @csrf
                <button type="submit" class="btn btn-dark">
                    Logout
                </button>
            </form>
        </div>
        <div class="container-grid">
            <div class="pict">
                @if ($user->user_profil_url === '' || $user->user_profil_url === null)
                    <img width="130px" height="130px" src="{{ asset('img/user.png') }}"
                        class="rounded m-2 d-block shadow-md" alt="...">
                @else
                    <img width="150px" height="150px"
                        src="{{ asset('storage/user/profile/' . basename($user->user_profil_url)) }}"
                        class="rounded m-2 d-block shadow-md" alt="...">
                @endif
            </div>
            <div class="data">
                <p><span>{{ $user->user_username }}</span></br>{{ $user->user_fullname }}</br>{{ $user->user_email }}</p>
                <div class="btn-container mt-3">
                    <button type="button" class="btn btn-light" onclick="openModal()">
                        <i class="fas fa-user-edit me-2"></i>Edit Profile
                    </button>
                </div>
            </div>
        </div>

        <div class="modal" id="updateUserModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="updateUserModalLabel">Ubah Profil</h1>
                    <button type="button" class="btn-close" onclick="closeModal()">×</button>
                </div>
                <form action="{{ route('DataUser.update', ['id' => $user->id]) }}" method="post" enctype="multipart/form-data" class="edit">
                    <div class="modal-body">
                        @csrf
                        @method('PATCH')
                        <div class="cf">
                            <label for="profil" class="form-label">Foto Profil</label>
                            <input type="file" name="profil" class="form-control" id="profil" placeholder="Tambahkan Foto Profil">
                        </div>
                        <div class="cl">
                            <div>
                                <label for="fullname" class="form-label">Nama User</label>
                                <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Masukkan Nama User" value="{{ $user->user_fullname }}" />
                            </div>
                            <div>
                                <label for="username" class="form-label">Username User</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Username User" value="{{ $user->user_username }}" />
                            </div>
                        </div>
                        <div class="cl">
                            <div>
                                <label for="password" class="form-label">Password User</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password User" value="{{ old('password') }}" />
                            </div>
                            <div>
                                <label for="email" class="form-label">E-mail User</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan E-mail User" value="{{ $user->user_email }}" />
                            </div>
                        </div>
                        <div class="cl">
                            <div>
                                <label for="notelp" class="form-label">No. Telp User</label>
                                <input type="number" name="notelp" class="form-control" id="notelp" placeholder="Masukkan No. Telp User" value="{{ $user->user_notelp }}" />
                            </div>
                            <div>
                                <label for="alamat" class="form-label">Alamat User</label>
                                <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat User" value="{{ $user->user_alamat }}" />
                            </div>
                        </div>
                        <input type="hidden" name="level" class="form-control" id="level" value="{{ $user->user_level }}" />
                        <input type="hidden" name="status" class="form-control" id="status" value="{{ $user->user_status }}" />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                    </div>
                 </form>
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
