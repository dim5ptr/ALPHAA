<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #365AC2, #AFC3FC);
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
            max-width: 1100px;
        }

        .login-box {
            display: flex;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .left, .right {
            flex: 1;
            padding: 40px;
        }

        .left {
            background-color: #e9edf9;
            color: #365AC2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .left img {
            width: 100%;
            max-width: 400px;
            height: auto;
            margin-bottom: 20px;
        }

        .right {
            background: #365AC2;
            color: #e9edf9;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .right h2 {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            color: #e9edf9;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }

        .input-group input {
            outline: none;
            width: 400px;
            height: 50px;
            padding: 18px;
            padding-left: 50px;
            border: 1px solid #ccc;
            background: #e9edf9;
            border-radius: 30px;
            font-size: 1rem;
        }

        .input-group input:hover {
            box-shadow: 0 0 5px #AFC3FC;
        }

        .input-group .icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #365AC2;
        }

        .forgot-password {
            text-align: right;
            width: 100%;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        input[type="submit"] {
            width: 100%;
            padding: 18px;
            background: #e9edf9;
            color: #365AC2;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 10px;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #AFC3FC;
            color: rgb(0, 0, 0);
        }

        .register-link {
            text-align: center;
            margin-top: 10px;
        }

        .register-link a {
            color: #afc3fc;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="login-box">
            <div class="left">
                <img src="{{ asset('img/B.png') }}" alt="Welcome Image">
            </div>
            <div class="right">
                <h2>Login</h2>


                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="username" id="username" name="username" placeholder="Username" value="{{ old('username') }}">
                        <span class="icon"><i class="fas fa-user"></i></span>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="Password">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                    </div>
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">Lupa Password?</a>
                    </div>
                    <input type="submit" value="Login" class="btn-login">
                </form>
                <br>
                <div class="register-link">
                    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
