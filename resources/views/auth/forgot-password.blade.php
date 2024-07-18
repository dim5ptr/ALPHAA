<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Kirim Tautan Reset Password
            </button>
        </form>

    </div>
</body>
</html>
