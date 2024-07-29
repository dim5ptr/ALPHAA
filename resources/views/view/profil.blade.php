<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Document</title>

    <style>
        /* CSS Anda disini */
        html, body {
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #d5def7;
        }

        body {
            transition: margin-left 0.3s;
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

        .nav-link-act {
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
            width: 80%;
            height: 100vh;
            flex: 1;
            margin-top: 5%;
            margin-left: 10%;
            transition: margin-left .3s;
        }

        .menu {
            display: flex;
            float: right;
            margin-right: 10%;
            margin-top: 3%;
            width: 80%;
            height: 70vh;
            margin-left: 4%;
        }

        .list2 {
            background-color: white;
            width: 18%;
            height: 98%;
            margin-top: 0.6%;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            box-shadow: 0 2px 5px 2px rgba(0, 0, 0, 0.1);
        }

        .list2 ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .list2 ul li {
            margin: 2 autopx, 0;
        }

        .nav-mini {
            display: block;
            padding: 10px;
            text-decoration: none;
            font-weight: 400;
            color: #365AC2;
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.3s;
        }

        .nav-mini-act {
            display: block;
            padding: 10px;
            text-decoration: none;
            font-weight: 600;
            color: #365AC2;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2), 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .nav-mini-act::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0%;
            width: 100%;
            height: 2px;
            background-color: #365AC2;
        }

        .nav-mini::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: #365AC2;
            transition: all 0.3s;
        }

        .nav-mini:hover::before {
            left: 0;
            width: 100%;
        }

        .nav-mini:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2), 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .page {
            background-color: white;
            width: 80%;
            height: 100%;
            border-radius: 5px;
            margin-right: 20;
            box-shadow: 0 2px 5px 2px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .inpage {
            margin-left: 10%;
            font-size: 15px;
        }

        .inpage h3 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .inpage p {
            margin-bottom: 3%;
        }

        .inpage input[type="password"] {
            width: 60%;
            padding: 15px;
            margin: 10px 0;
            margin-bottom: 2%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .inpage button {
            background-color: #365AC5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .inpage button:hover {
            background-color: #365AA3;
        }

        .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
        display: block;
        }
        .error {
            border: 1px solid red;
        }

    </style>
</head>
<body>
    <nav class="navbar">
        <p class="p1"><span>{{ \Carbon\Carbon::now()->format('l') }} </span><br>{{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    </nav>

    <button class="open-btn" onclick="toggleSidebar()">&#9776; Security</button>

    <div id="sidebar" class="sidebar">
        <div class="sidebar-isi">
            <ul class="list">
                <li>
                    <a href="/dashboard" class="nav-link">
                        <span class="link"><i class="fa-solid fa-house-chimney"></i>ㅤDashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/profil" class="nav-link">
                        <span class="link"><i class="fa-solid fa-id-card"></i>ㅤProfile</span>
                    </a>
                </li>
                <li>
                    <a href="/security" class="nav-link-act">
                        <span class="link"><i class="fa-solid fa-user-shield"></i>ㅤSecurity</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div id="main-content" class="main-content">
        <div class="banner">
            <div class="judul">
                <h4>Akun Pengguna</h4>
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
    </div>
    <script>
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
</body>
</html>
