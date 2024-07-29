<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <body>
        <div class="navbar">
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
    </div>

    <div class="main-content">
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
    </script>
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
    </script>

    </body>
</body>
</html>
