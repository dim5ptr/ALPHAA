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
        margin-right: 20px;
    }

    .profile-info .data {
        flex: 1;
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

    /* Navbar styles */
    /* General Navbar Styles */
.navbar {
    height: auto;
    margin-top: 1%;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    background: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    align-items: center;
}

.navbar .container {
    display: flex;
    align-items: center;
    flex: 1;
}

.navbar .container img {
    width: 100px; /* Adjust width as needed */
}

.navbar a {
    color: #365AC2;
    text-decoration: none;
    margin: 0 10px;
    font-size: 18px;
    font-weight: 900;
}

.navbar .aiken {
    display: flex;
    align-items: center;
}

/* Icon Styles */
.navbar .aiken i {
    color: #365AC2;
    font-size: 24px; /* Adjust font size as needed */
}

/* Responsive Styles */
@media (max-width: 1024px) {
    .navbar {
        flex-direction: column;
        align-items: flex-start;
    }

    .navbar .container,
    .navbar .aiken {
        width: 100%;
        justify-content: center;
        text-align: center;
    }

    .navbar .container img {
        width: 80px; /* Adjust width for smaller screens */
    }

    .navbar a {
        margin: 5px 10px;
        font-size: 16px; /* Adjust font size for smaller screens */
    }

    .navbar .aiken i {
        font-size: 20px; /* Adjust font size for smaller screens */
    }
}

@media (max-width: 768px) {
    .navbar {
        padding: 10px;
    }

    .navbar .container img {
        width: 60px; /* Further adjust width for mobile screens */
    }

    .navbar a {
        font-size: 14px; /* Adjust font size for mobile screens */
    }

    .navbar .aiken i {
        font-size: 18px; /* Adjust font size for mobile screens */
    }
}

@media (max-width: 480px) {
    .navbar {
        padding: 5px;
    }

    .navbar .container img {
        width: 50px; /* Further adjust width for extra-small screens */
    }

    .navbar a {
        font-size: 12px; /* Adjust font size for extra-small screens */
    }

    .navbar .aiken i {
        font-size: 16px; /* Adjust font size for extra-small screens */
    }
}

 /* Add new styles for the new modal */
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

</style>
@endsection
@section('main')
<header class="navbar">
    <div class="container">
        <img src="img/logo_sarastya.png" alt="Logo">
    </div>
    <div class="aiken">
        <a href="{{ route('dashboard') }}">
            <i class="fas fa-home"></i>
        </a>
        <a href="{{ route('profil') }}">
            <i class="fas fa-user"></i>
        </a>
    </div>
</header>

<div class="container-flex">
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
        <img id="profileImage" src="{{ $personalInfo['image'] ? asset('storage/' . $personalInfo['image']) : 'https://via.placeholder.com/150' }}" alt="Profile Image" width="150" height="150">
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
                <strong>Address:</strong> {{ $personalInfo['Address'] ?? 'Not Provided' }}
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
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" class="form-control" id="address" value="{{ old('address', $personalInfo['address']) }}">
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
        <form action="{{ route('profilePicture.update') }}" method="POST" enctype="multipart/form-data">
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
                <input type="file" name="image" class="form-control" id="profile_image">
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
</script>


@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@endsection
