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
    <link href="https://fonts.googleapis.com/css2?family=Righteous&family=Lato:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body data-wallpaper="{{ $wallpaper ?? '' }}">

    <!-- Parallax Background -->
    <div id="parallax-bg" aria-hidden="true"></div>

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

    <script>
    (function() {
        // Semua wallpaper
        var wallpapers = [
            '{{ asset("images/wallpapers/amany-firdaus-Vhs3BXQcBeI-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/john-roy-CrVGV4m0H3A-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/muhammad-haikal-sjukri-npQ71wfg5pQ-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/navi-pIAketNRHrQ-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/sathsara-priyankara-YqMA-ALTa-E-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/suneth-nawoda-de-silva-obiV2y8iFzE-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/turnando-alzaman-2JcFGglOf-0-unsplash.jpg") }}',
        ];

        // Beranda = wallpaper ke-0 (tetap), halaman lain = acak dari semua 7
        var isHome = (window.location.pathname === '/' || window.location.pathname === '');
        var idx;
        if (isHome) {
            idx = 0;
        } else {
            // Cek sessionStorage supaya tiap page visit beda tapi tidak berubah saat refresh
            var storageKey = 'wp_' + window.location.pathname;
            var saved = sessionStorage.getItem(storageKey);
            if (saved !== null) {
                idx = parseInt(saved);
            } else {
                idx = Math.floor(Math.random() * wallpapers.length);
                sessionStorage.setItem(storageKey, idx);
            }
        }

        var bg     = document.getElementById('parallax-bg');
        var layerA = document.createElement('div');
        var layerB = document.createElement('div');
        layerA.className = layerB.className = 'parallax-layer';
        bg.appendChild(layerA);
        bg.appendChild(layerB);

        layerA.style.backgroundImage = 'url(' + wallpapers[idx] + ')';
        layerA.style.opacity = '1';
        layerB.style.opacity  = '0';

        // Preload gambar lain
        wallpapers.forEach(function(src, i) {
            if (i !== idx) { var img = new Image(); img.src = src; }
        });

        // ── Parallax scroll ──────────────────────────────────────────
        // Gambar bergerak NAIK (translateY negatif) saat scroll turun,
        // dengan kecepatan 1/3 scroll. Dibatasi agar tidak keluar frame.
        var SPEED = 0.33;   // gambar bergerak 1/3 scroll user

        var ticking = false;
        function applyParallax() {
            var scrollTop  = window.pageYOffset;
            var maxScroll  = Math.max(1, document.documentElement.scrollHeight - window.innerHeight);
            // Buffer yang tersedia = 30% viewport height (dari inset: -30%)
            var maxTravel  = window.innerHeight * 0.30;
            // Negatif = image naik saat scroll turun → efek parallax benar
            var raw        = -(scrollTop * SPEED);
            // Clamp agar image tidak keluar batas atas/bawah
            var clamped    = Math.max(-maxTravel, Math.min(0, raw));

            layerA.style.transform = 'translateY(calc(-30% + ' + clamped + 'px))';
            layerB.style.transform = 'translateY(calc(-30% + ' + clamped + 'px))';
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) { requestAnimationFrame(applyParallax); ticking = true; }
        }, { passive: true });

        // Inisialisasi posisi awal
        applyParallax();

        // ── Fade out → navigasi → fade in ────────────────────────────
        document.querySelectorAll('a').forEach(function(link) {
            var href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript') || href.startsWith('mailto')) return;
            // Lewati link eksternal
            try {
                var url = new URL(href, window.location.href);
                if (url.hostname !== window.location.hostname) return;
            } catch(e) { return; }

            link.addEventListener('click', function(e) {
                var target = link.getAttribute('href');
                if (target && !target.startsWith('#')) {
                    e.preventDefault();
                    bg.style.transition = 'opacity 0.45s ease';
                    bg.style.opacity    = '0';
                    document.body.style.transition = 'opacity 0.45s ease';
                    document.body.style.opacity    = '0';
                    setTimeout(function() { window.location.href = target; }, 430);
                }
            });
        });

        // Fade in saat halaman dimuat
        bg.style.opacity   = '0';
        bg.style.transition = 'opacity 0.7s ease';
        document.body.style.opacity   = '0';
        document.body.style.transition = 'opacity 0.7s ease';
        setTimeout(function() {
            bg.style.opacity   = '1';
            document.body.style.opacity = '1';
        }, 60);
    })();
    </script>

</body>
</html>