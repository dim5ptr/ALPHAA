@extends('layouts.app')

@auth
    @php
        $userRole = Auth::user()->user_level;
        $user = Auth::user();
    @endphp
@endauth

@section('title', 'Data Profil')

@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    body {
        background-color: #d5def7;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
        width: 100%;
        height: 100%;
        transition: margin-left 0.3s;
    }

    ::-webkit-scrollbar {
        width: 0px;
    }

    .text-bg-dark {
        color: #000000;
    }

    .btn-primary, .btn-dark, .btn-danger, .btn-light {
        padding: 8px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-light {
        background-color: #365AC2;
        font-size: small;
        font-weight: bold;
        color: #d5def7;
    }

    .btn-dark {
        background-color: #000000;
        color: white;
        font-weight: bold;
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
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 10px;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e5e5e5;
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        margin-bottom: 2.1%;
    }

    .modal-header h1 {
        margin: 0;
        font-size: 24px;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: white;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .form-label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        font-size: 14px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        border-top: 1px solid #e5e5e5;
        padding-top: 10px;
        margin-top: 20px;
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
        max-width: 90%;
        background-color: white;
        margin: 4.5% auto;
        border-radius: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .banner {
        width: 100%;
        background-color: #0056b3;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
        margin-top: 20px;
    }

    .banner h4 {
        margin: 0;
        font-size: 24px;
    }

    .profile-info {
        display: flex;
        align-items: center;
        width: 100%;
        margin-top: 20px;
    }

    .profile-info img {
        border-radius: 50%;
        margin-right: 50px;
    }

    .profile-info .data {
        flex: 1;
        margin-left: 30px;
        margin-top: 50px
    }

    .profile-info .data span {
        font-size: 18px;
        color: #000000;
    }

    .profile-info .data p {
        font-size: 16px;
        color: rgb(92, 89, 89);
    }

    .btn-container {
        display: flex;
        justify-content: flex-start;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .profile-info {
            flex-direction: column;
            align-items: center;
        }

        .profile-info img {
            margin-bottom: 20px;
        }

        .profile-info .data span, .profile-info .data p {
            text-align: center;
        }
    }


 .modal-image {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-image-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 10px;
    }

    .modal-image-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e5e5e5;
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        margin-bottom: 2.1%;
    }

    .modal-image-header h1 {
        margin: 0;
        font-size: 24px;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: white;
    }

    .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -270px;
            background-color: white;
            overflow-x: hidden;
            transition: 0.3s;
            padding-top: 100px;
            box-shadow: 1px 0 9px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar .sidebar-isi {
            display: block;
            padding: 0px;
            height: 100%;
        }

        .sidebar-isi .list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .list .nav-link {
            margin-left: 6%;
            display: flex;
            align-items: center;
            padding: 14px 17px;
            margin-bottom: 2%;
            border-radius: 5px;
            text-decoration: none;
            width: calc(100% - 40px);
            box-sizing: border-box;
            position: relative;
            justify-content: flex-start;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-link .link {
            font-size: 17px;
            color: #365AC2;
            font-weight: 400;
            transition: color 0.3s;
        }

        .nav-link .nav-link-act i {
            padding-right: 10px;
            font-size: 20px;
            color: #365AC2;
            cursor: pointer;
            transition: color 0.3s;
        }

        .nav-link:hover {
            background-color: #365AC2;
        }

        .nav-link:hover i,
        .nav-link:hover .link {
            color: white;
        }

        .nav-link-action {
            margin-left: 6%;
            display: flex;
            align-items: center;
            padding: 14px 17px;
            margin-bottom: 2%;
            border-radius: 5px;
            text-decoration: none;
            width: calc(100% - 40px);
            box-sizing: border-box;
            position: relative;
            justify-content: flex-start;
            background-color: #365AC2;
            color: white;
        }

        .navbar {
            position: fixed;
            background-color: white;
            padding: 0px;
            display: flex;
            justify-content: flex-end;
            font-size: 14px;
            box-shadow: 0 2px 9px rgba(0, 0, 0, 0.2);
            width: 100%;
            top: 0;
            z-index: 900;
        }

        .navbar p {
            margin-right: 2%;
            padding: 0;
            color: gray;
        }

        .navbar span {
            font-weight: 800;
            color: #365AC2;
            font-size: 16px;
        }

        .open-btn {
            position: fixed;
            left: 2%;
            top: 2.5%;
            cursor: pointer;
            color: #365AC2;
            font-size: 20px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
            z-index: 1001;
            background: none;
        }

        .open-btn:hover {
            color: darkblue;
        }

        .main-content {
            width: calc(100% - 270px);
            height: 100%;
            flex: 1;
            margin-top: 5%;
            margin-left: 10%;
            transition: margin-left .3s;
        }
        .logout {
            list-style: none;
            height: 50%;
            top: 50%;

        }
        .out-link {
            margin-left: 15%;
            display: flex;
            align-items: center;
            padding: 8px 9px;
            margin-bottom: 2%;
            border-radius: 5px;
            text-decoration: none;
            width: calc(80% - 40px);
            box-sizing: border-box;
            position: relative;
            top: 90%;
            background-color: white;
            border: 2px solid #c23636;
            transition: background-color 0.3s, color 0.3s;
        }

        .out-link:hover {
            background-color: #ff0000;
            color: aliceblue;
            border: 2px solid aliceblue;
        }
</style>
@endsection
@section('main')
<header class="navbar">
    <nav class="navbar">
        <p class="p1"><span>{{ \Carbon\Carbon::now()->format('l') }},</span><br>{{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    </nav>

    <button class="open-btn" onclick="toggleSidebar()">&#9776; Dashboard</button>

    <div id="sidebar" class="sidebar">
        <div class="sidebar-isi">
            <ul class="list">
                <li>
                    <a href="/dashboard" class="nav-link">
                        <span class="link"><i class="fa-solid fa-house-chimney"></i>ㅤDashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/profil" class="nav-link-action">
                        <span class="link"><i class="fa-solid fa-id-card"></i>ㅤProfile</span>
                    </a>
                </li>
                <li>
                    <a href="/change-password" class="nav-link">
                        <span class="link"><i class="fa-solid fa-user-shield"></i>ㅤSecurity</span>
                    </a>
                </li>
            </ul>
            <li class="logout">
                <a href="" class="out-link">
                    <span class="link"><i class='bx bx-log-out'></i>Logout</span>
                </a>
            </li>
            </ul>
        </div>
    </div>
</header>



<div class="container-flex">
    @if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
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

    <div class="profile-info">
        @if ($personalInfo['profile_picture'] === '' || $personalInfo['profile_picture'] === null)
            <img id="profileImage" src="{{ asset('img/user.png') }}" alt="Profile Image" width="150" height="150" class="rounded m-2 mx-auto d-block shadow-md">
        @else
            <img id="profileImage" src="{{ asset('storage/user/profile/' . basename($personalInfo['profile_picture'])) }}" alt="Profile Image" width="150" height="150" class="rounded m-2 mx-auto d-block shadow-md">
        @endif
        <div class="data">
            <p>
                <span><strong>Username:</strong> {{ $personalInfo['username'] }}</span><br>
                <strong>Full Name:</strong> {{ $personalInfo['fullname'] }}<br>
                <strong>Email:</strong> {{ $personalInfo['email'] }}<br>
                <strong>Phone:</strong> {{ $personalInfo['phone'] ?? 'Not Provided' }}<br>
                <strong>Date of Birth:</strong> {{ $personalInfo['birthday'] ?? 'Not Provided' }}<br>
                <strong>Gender:</strong>
                @if($personalInfo['gender'] == 1)
                    Male
                @elseif($personalInfo['gender'] == 0)
                    Female
                @else
                    Not Provided
                @endif
                </span><br>
            </p>
            <div class="btn-container">
                <button type="button" class="btn btn-light" onclick="openModal()">
                    <i class="fas fa-user-edit me-2"></i>Edit Profile
                </button>
                <button type="button" class="btn btn-light" onclick="openImageModal()">
                    <i class="fas fa-image me-2"></i>Change Profile Image
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Profile Update Modal -->
<div class="modal" id="updateUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title" id="updateUserModalLabel">Ubah Profil</h1>
            <button type="button" class="btn-close" onclick="closeModal()">×</button>
        </div>
        <form action="{{ route('personalInfo.update') }}" method="POST">
            @csrf
            @method('PATCH')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" value="{{ old('username', $personalInfo['username']) }}">
            </div>
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" name="fullname" class="form-control" id="fullname" value="{{ old('fullname', $personalInfo['fullname']) }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $personalInfo['email']) }}" disabled>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone', $personalInfo['phone']) }}">
            </div>
            <div class="mb-3">
                <label for="birthday" class="form-label">Date of Birth</label>
                <input type="date" name="birthday" class="form-control" id="birthday" value="{{ old('birthday', $personalInfo['birthday']) }}">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" class="form-control" id="gender">
                    <option value="1" {{ old('gender', $personalInfo['gender']) == '1' ? 'selected' : '' }}>Male</option>
                    <option value="0" {{ old('gender', $personalInfo['gender']) == '0' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Profile Image Update Modal -->
<div class="modal-image" id="updateImageModal">
    <div class="modal-image-content">
        <div class="modal-image-header">
            <h1 class="modal-title" id="updateImageModalLabel">Change Profile Image</h1>
            <button type="button" class="btn-close" onclick="closeImageModal()">×</button>
        </div>
        <form action="{{ route('upload.profile.picture') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image</label>
                <input type="file" name="profile_picture" class="form-control" id="profile_image">
            </div>
            <div class="modal-image-footer">
                <button type="button" class="btn btn-secondary" onclick="closeImageModal()">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('updateUserModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('updateUserModal').style.display = 'none';
    }

    function openImageModal() {
        document.getElementById('updateImageModal').style.display = 'block';
    }

    function closeImageModal() {
        document.getElementById('updateImageModal').style.display = 'none';
    }

    document.querySelector('form').addEventListener('submit', function() {
        closeModal();
        closeImageModal();
    });

    function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            var mainContent = document.getElementById("main-content");

            if (sidebar.style.left === "0px") {
                sidebar.style.left = "-270px";
                mainContent.style.marginLeft = "10%";
            } else {
                sidebar.style.left = "0px";
                mainContent.style.marginLeft = "19%";
            }
        }
</script>



@endsection
