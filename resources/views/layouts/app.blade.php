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
        // Menggunakan background-position-y sehingga gambar TIDAK pernah terpotong.
        // Saat scroll=0 → posisi 50% (tengah gambar terlihat)
        // Saat scroll turun → posisi bergerak ke atas (angka kecil = lebih ke atas)
        // Kecepatan: setiap scroll 3px → posisi berubah ~1 unit

        var SPEED = 0.015; // semakin kecil = semakin lambat parallax

        var ticking = false;
        function applyParallax() {
            var scrollTop = window.pageYOffset;
            var maxScroll = Math.max(1, document.documentElement.scrollHeight - window.innerHeight);
            // progress: 0 (atas) → 1 (bawah)
            var progress = scrollTop / maxScroll;
            // posY: 50% saat di atas, turun ke 30% saat scroll habis (gambar naik perlahan)
            var posY = 50 - (progress * 25);  // range: 50% → 25%
            var posYpx = Math.round(posY * 10) / 10;

            layerA.style.backgroundPosition = 'center ' + posYpx + '%';
            layerB.style.backgroundPosition = 'center ' + posYpx + '%';
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
            if (!href || href.startsWith('javascript') || href.startsWith('mailto')) return;
            
            try {
                var url = new URL(link.href); // Gunakan link.href yang sudah absolute
                // Lewati link eksternal
                if (url.hostname !== window.location.hostname) return;
                
                // Jika link menuju halaman yang sama (misal /#about dari /)
                if (url.pathname === window.location.pathname && url.hash) {
                    return; // Biarkan browser melakukan smooth scroll
                }
                // Jika halaman sama tanpa hash (contoh klik home saat di home)
                if (url.pathname === window.location.pathname && !url.hash && href !== '/') {
                     return;
                }
            } catch(e) { return; }

            link.addEventListener('click', function(e) {
                // Jangan intercept jika buka tab baru (Ctrl+Click / target="_blank")
                if (e.ctrlKey || e.metaKey || link.target === '_blank') return;

                e.preventDefault();
                bg.style.transition = 'opacity 0.45s ease';
                bg.style.opacity    = '0';
                document.body.style.transition = 'opacity 0.45s ease';
                document.body.style.opacity    = '0';
                setTimeout(function() { window.location.href = link.href; }, 430);
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