<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Libretto</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mt-3">
        <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
            <h3 class="mb-0">Libretto</h3>
        </a>
            @auth
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            @endauth
        </div>
        
        @yield('content')
        
        <div class="row justify-content-center text-center mt-3">
            <div class="col-md-12">
                <p>
                    Jabez Aguspina all rights reserved.
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>