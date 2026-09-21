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
        // Daftar wallpaper
        var wallpapers = [
            '{{ asset("images/wallpapers/amany-firdaus-Vhs3BXQcBeI-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/john-roy-CrVGV4m0H3A-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/muhammad-haikal-sjukri-npQ71wfg5pQ-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/navi-pIAketNRHrQ-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/sathsara-priyankara-YqMA-ALTa-E-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/suneth-nawoda-de-silva-obiV2y8iFzE-unsplash.jpg") }}',
            '{{ asset("images/wallpapers/turnando-alzaman-2JcFGglOf-0-unsplash.jpg") }}',
        ];

        // Pilih wallpaper berdasarkan halaman
        var pageKey = window.location.pathname;
        var pageMap = {
            '/':             0,
            '/mata-desa':    1,
            '/rekomendasi':  2,
            '/logistik':     3,
            '/lapor-tanam':  4,
        };
        var idx = (pageMap[pageKey] !== undefined) ? pageMap[pageKey] : (Math.abs(pageKey.split('').reduce(function(a,c){return a+c.charCodeAt(0);},0)) % wallpapers.length);
        var bg = document.getElementById('parallax-bg');

        // Buat dua layer untuk efek fade in/out saat navigasi
        var layerA = document.createElement('div');
        var layerB = document.createElement('div');
        layerA.className = layerB.className = 'parallax-layer';
        bg.appendChild(layerA);
        bg.appendChild(layerB);

        // Set gambar
        layerA.style.backgroundImage = 'url(' + wallpapers[idx] + ')';
        layerA.style.opacity = '1';
        layerB.style.opacity = '0';

        // Preload gambar berikutnya diam-diam
        var nextIdx = (idx + 1) % wallpapers.length;
        var preload = new Image();
        preload.src = wallpapers[nextIdx];

        // Parallax scroll — image bergerak 1/3 kecepatan scroll
        var ticking = false;
        function onScroll() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    var offset = window.pageYOffset;
                    var translateY = offset * 0.33;
                    layerA.style.transform = 'translateY(' + translateY + 'px)';
                    layerB.style.transform = 'translateY(' + translateY + 'px)';
                    ticking = false;
                });
                ticking = true;
            }
        }
        window.addEventListener('scroll', onScroll, { passive: true });

        // Fade out saat klik link halaman lain
        document.querySelectorAll('a').forEach(function(link) {
            var href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('mailto') || href.startsWith('http') && !href.includes(window.location.hostname)) return;
            link.addEventListener('click', function(e) {
                var target = link.getAttribute('href');
                // Hanya intercept internal links
                if (target && !target.startsWith('#') && !target.startsWith('javascript')) {
                    e.preventDefault();
                    bg.style.transition = 'opacity 0.5s ease';
                    bg.style.opacity = '0';
                    setTimeout(function() {
                        window.location.href = target;
                    }, 450);
                }
            });
        });

        // Fade in saat halaman load
        bg.style.opacity = '0';
        bg.style.transition = 'opacity 0.7s ease';
        setTimeout(function() { bg.style.opacity = '1'; }, 50);
    })();
    </script>

</body>
</html>