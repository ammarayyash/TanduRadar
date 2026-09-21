<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $group_title ?? 'Portofolio' }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>

    <header class="navbar">
        <div class="container nav-container">
            <a href="/" class="logo" style="display:flex; align-items:center;">
                <img src="{{ asset('images/logo.png') }}" alt="{{ $group_name }}" style="height:50px; width:auto;">
            </a>
            <nav>
                <ul class="nav-links">
                    <li><a href="/#home">Home</a></li>
                    <li><a href="/#about">About</a></li>
                    <li><a href="/#team">Team</a></li>
                    <li><a href="/#contact">Kontak</a></li>
                    <li><a href="{{ route('mata-desa') }}" style="color:var(--primary)"><i class="fas fa-seedling"></i> Mata Desa</a></li>
                    <li><a href="{{ route('rekomendasi') }}" style="color:var(--primary)">Rekomendasi</a></li>
                    <li><a href="{{ route('logistik') }}" style="color:var(--primary)">Logistik</a></li>
                    <li><a href="{{ route('lapor-tanam') }}" class="btn btn-primary" style="padding:6px 14px;font-size:.85rem">Lapor Tanam</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ $group_name }}. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>