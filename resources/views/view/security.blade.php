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
            <div class="menu">
                <div class="list2">
                    <ul>
                        <li>
                            <a href="/pw" class="nav-mini-act">
                                <span class="link">Password</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-mini">
                                <span class="link">comingsoon</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-mini">
                                <span class="link">comingsoon</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="page">
                    <div class="inpage">
                        <h3>Manage Your Password</h3>
                        <p>Your new password must be different from your previous used password.</p>
                        <form id="change-password-form" method="POST" action="{{ route('change-password') }}">
                            @csrf
                            <div>
                                <label for="current_password">Current Password</label><br>
                                <input type="password" id="current_password" name="current_password" required>
                                <span id="current_password_error" class="error-message"></span>
                            </div>
                            <div>
                                <label for="new_password">New Password</label><br>
                                <input type="password" id="password" name="password" required>
                                <span id="new_password_error" class="error-message"></span>
                            </div>
                            <div>
                                <label for="confirm_password">Confirm New Password</label><br>
                                <input type="password" id="password_confirmation" name="password_confirmation" required>
                                <span id="confirm_password_error" class="error-message"></span>
                            </div>
                            <button type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            if (sidebar.style.left === '0px') {
                sidebar.style.left = '-270px';
            } else {
                sidebar.style.left = '0px';
            }
        }
        function validatePassword() {
    const currentPassword = document.getElementById('current_password');
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');

    const currentPasswordError = document.getElementById('current_password_error');
    const newPasswordError = document.getElementById('new_password_error');
    const confirmPasswordError = document.getElementById('confirm_password_error');

    let valid = true;

    // Clear previous errors
    currentPassword.classList.remove('error');
    newPassword.classList.remove('error');
    confirmPassword.classList.remove('error');
    currentPasswordError.textContent = '';
    newPasswordError.textContent = '';
    confirmPasswordError.textContent = '';

    // Validate current password
    if (currentPassword.value.trim() === '') {
        currentPassword.classList.add('error');
        currentPasswordError.textContent = 'Current password is required';
        valid = false;
    }

    // Validate new password
    if (newPassword.value.trim() === '') {
        newPassword.classList.add('error');
        newPasswordError.textContent = 'New password is required';
        valid = false;
    } else if (newPassword.value.length < 8) {
        newPassword.classList.add('error');
        newPasswordError.textContent = 'New password must be at least 8 characters long';
        valid = false;
    }

    // Validate confirm password
    if (confirmPassword.value.trim() === '') {
        confirmPassword.classList.add('error');
        confirmPasswordError.textContent = 'Confirm password is required';
        valid = false;
    } else if (confirmPassword.value !== newPassword.value) {
        confirmPassword.classList.add('error');
        confirmPasswordError.textContent = 'Passwords do not match';
        valid = false;
    }

    return valid;
}

// Validate on input event
document.getElementById('change-password-form').addEventListener('input', validatePassword);

// Optionally validate on form submission as well
document.getElementById('change-password-form').addEventListener('submit', function(event) {
    if (!validatePassword()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});

    </script>
</body>
</html>
