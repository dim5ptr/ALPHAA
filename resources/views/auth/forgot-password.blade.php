<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Reset Password</title>

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

        .reset-password-box {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background-color: #e9edf9;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .reset-password-box h2 {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            color: #365AC2;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }

        .input-group input {
            outline: none;
            width: 100%;
            height: 50px;
            padding: 18px;
            padding-left: 50px;
            border: 1px solid #ccc;
            background: #fff;
            border-radius: 30px;
            font-size: 1rem;
        }

        .input-group .icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #365AC2;
        }

        input[type="submit"] {
            width: 100%;
            padding: 18px;
            background: #365AC2;
            color: #e9edf9;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 10px;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #2e4d91;
        }
    </style>
</head>
<body>
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
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
        <div class="reset-password-box">
            <h2>Reset Password</h2>
            <form action="{{ route('password.update') }}" method="post">
                @csrf
                {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email" value="{{ $email ?? old('email') }}" required>
                    <span class="icon"><i class="fas fa-envelope"></i></span>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="icon"><i class="fas fa-lock"></i></span>
                </div>
                <div class="input-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
                    <span class="icon"><i class="fas fa-lock"></i></span>
                </div>
                <input type="submit" value="Reset Password">
            </form>
        </div>
    </div>
</body>
</html>
