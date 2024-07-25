<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Sliding Sidebar</title>
    <style>
          html, body {
            height: 100%;
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
            padding-right: 15px;
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
            color: white; /* Sesuaikan warna ikon dan teks */
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

        /* .logout {
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
            border: 2px solid #365AC2;
            transition: background-color 0.3s, color 0.3s;
        }

        .out-link:hover {
            background-color: #365AC0;
            color: aliceblue;
            border: 2px solid aliceblue;
        } */


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
            height: 100%;
            flex: 1;
            margin-top: 5%;
            margin-left: 10%;
            transition: margin-left .3s;
        }

        .bar {
            display: flex;
            float: right;
            margin-right: 10%;
            margin-top: 2%;
            border-radius: 5px;
            background-color: white;
            width: 80%;
            height: 25%;
            margin-left: 4%;
            box-shadow: 0 2px 5px 2px rgba(0, 0, 0, 0.1); /* Add box shadow */
        }

        .grt {
            padding-left: 5%;
            width: 50%;
        }

        .bar img {
            width: 20%;
            height: 80%;
            float: left;
            margin-left: 2%;
            margin-top: 2%;

        }

        .grt h1{
            margin-left: 2%;
            padding-top: 2%;
           font-size: 40px;
           font-weight: 700;

        }

        .bar2 {
            float: right;
            margin-right: 10%;
            margin-top: 2%;
            border-radius: 5px;
            background-color: white;
            width: 80%;
            height: 75%;
            margin-left: 4%;
            box-shadow: 0 2px 5px 2px rgba(0, 0, 0, 0.1); /* Add box shadow */
        }

        .ttl {
            margin-left: 5%;
            margin-bottom: 5%;
            margin-top: 5%;
            color: #38393e;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <p class="p1"><span>{{ \Carbon\Carbon::now()->format('l') }},</span></br>{{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    </nav>

    <button class="open-btn" onclick="toggleSidebar()">&#9776; Dashboard</button>

    <div id="sidebar" class="sidebar">
        <div class="sidebar-isi">
            <ul class="list">
                <li>
                    <a href="#" class="nav-link-act">
                        <span class="link"><i class='bx bxs-home'></i>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link">
                        <span class="link"><i class='bx bx-layout'></i>List User</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link">
                        <span class="link"><i class='bx bxs-user-detail'></i>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link">
                        <span class="link"><i class='bx bxs-cog'></i>Settings</span>
                    </a>
                </li>
            </ul>
            {{-- <li class="logout">
                <a href="#" class="out-link">
                    <span class="link"><i class='bx bx-log-out'></i>Logout</span>
                </a>
            </li> --}}
        </div>
    </div>

    <div id="main-content" class="main-content">
        <div class="bar">
            <img src="img/logo_sarastya.png">
            <div class="grt">
                <h1>Dashboard Admin</h1>
                <h4>Jumlah pengguna masuk hari ini :
                    <span>n%</span></h4>
            </div>
        </div>
        <div class="bar2">
            <div class="ttl">
                <h2>Login History</h2>
            </div>
            <div class="tbl">

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
    </script>
</body>
</html>
