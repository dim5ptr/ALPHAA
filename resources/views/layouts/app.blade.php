<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="img/logo_sarastya.jpg">
    {{-- ? CSS ? --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    {{-- ? JavaScript ? --}}
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body>
    <div class="preloader">
        <div class="preloader-spinner"></div>
    </div>
    <header>
        @yield('header')
    </header>
    <main>
        @yield('main')
    </main>
    <footer class="pt-4">
        @yield('footer')
    </footer>
</body>

</html>
