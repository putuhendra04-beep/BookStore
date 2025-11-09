<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '📚 Bookstore App')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar-brand {
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .navbar-nav .nav-link {
            color: white !important;
            transition: all 0.3s ease;
            border-radius: 5px;
            padding: 8px 12px;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #f8f9fa !important;
            transform: translateY(-2px);
        }

        
        .navbar-nav .nav-link.active {
            border-bottom: 2px solid white;
            padding-bottom: 4px;
          

        }

        footer {
            margin-top: 60px;
            padding: 20px 0;
            text-align: center;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>

<body>
    {{-- 🔹 Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark mb-4" style="background-color: #5bc0de;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('topbook.index') }}">
                <h2>📚 Bookstore</h2>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navbarNav" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('home.index') }}"
                            class="nav-link {{ Route::is('home.*') ? 'active' : '' }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('books.index') }}"
                            class="nav-link {{ Route::is('books.*') ? 'active' : '' }}">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('authors.index') }}"
                            class="nav-link {{ Route::is('authors.*') ? 'active' : '' }}">Penulis</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}"
                            class="nav-link {{ Route::is('categories.*') ? 'active' : '' }}">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('ratings.index') }}"
                            class="nav-link {{ Route::is('ratings.*') ? 'active' : '' }}">Rating</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <small>© {{ date('Y') }} Bookstore App — Dibuat dengan ❤️ Laravel</small>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>