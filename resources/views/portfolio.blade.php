@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container hero-content">
        <img src="{{ asset('images/logo.png') }}" alt="{{ $group_name }} Logo" style="width: 220px; max-width: 80%; height: auto; display: block; margin: 0 auto 24px; image-rendering: crisp-edges;">
        <span class="tag">🌾 Portofolio Resmi &nbsp;·&nbsp; Kelompok 10</span>
        <h1>{{ $hero_title }} oleh <span>{{ $group_name }}</span></h1>
        <p>{{ $hero_subtitle }}</p>
        <div class="hero-buttons">
            <a href="#projects" class="btn btn-primary"><i class="fas fa-rocket"></i> Lihat Proyek</a>
            <a href="#team" class="btn btn-secondary"><i class="fas fa-users"></i> Tim Kami</a>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="section about">
    <div class="container">
        <div class="section-header">
            <h2>Tentang Kelompok</h2>
            <div class="divider-line"></div>
            <p style="margin-top:16px;">Kami berkolaborasi untuk menciptakan solusi teknologi pertanian yang berdampak nyata bagi masyarakat desa.</p>
        </div>
        <div class="about-stats">
            <div style="text-align:center;">
                <span class="about-stat-num">4</span>
                <span class="about-stat-label">Modul Sistem</span>
            </div>
            <div style="text-align:center;">
                <span class="about-stat-num">2</span>
                <span class="about-stat-label">Anggota Tim</span>
            </div>
            <div style="text-align:center;">
                <span class="about-stat-num">∞</span>
                <span class="about-stat-label">Dampak Petani</span>
            </div>
        </div>
    </div>
</section>

<!-- TanduRadar System Section -->
<section id="tanambijak" class="section" style="padding-top:20px;">
    <div class="container">
        <div class="section-header">
            <h2><span style="color:var(--primary)">🌱 TanduRadar</span> — Proyek Unggulan</h2>
            <p>Platform manajemen rotasi tanam berbasis komunitas untuk mencegah oversupply komoditas pertanian</p>
        </div>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(260px,1fr)); gap:20px; margin-bottom:30px;">
            <a href="{{ route('mata-desa') }}" class="card" style="text-align:center;">
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&q=80" alt="Mata Desa" style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                <h3>Mata Desa</h3>
                <p class="bio">Visualisasi distribusi komoditas real-time per kecamatan dengan indikator Merah/Kuning/Hijau.</p>
                <span class="project-link">Buka Modul <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="{{ route('rekomendasi') }}" class="card" style="text-align:center;">
                <img src="https://images.unsplash.com/photo-1628183213364-e69c1184ff10?w=600&q=80" alt="Rekomendasi Cerdas" style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                <h3>Rekomendasi Cerdas</h3>
                <p class="bio">Saran komoditas alternatif saat lahan jenuh, lengkap dengan kalkulator estimasi keuntungan.</p>
                <span class="project-link">Buka Modul <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="{{ route('logistik') }}" class="card" style="text-align:center;">
                <img src="https://images.unsplash.com/photo-1586864387967-d02ef85d93e8?w=600&q=80" alt="Eco-Logistik" style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                <h3>Eco-Logistik</h3>
                <p class="bio">Jadwal panen desa & koordinasi armada truk. Tracker sayur terselamatkan dari food waste.</p>
                <span class="project-link">Buka Modul <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="{{ route('lapor-tanam') }}" class="card" style="text-align:center; border-color:var(--primary);">
                <img src="https://images.unsplash.com/photo-1592982537447-7440770cbfc9?w=600&q=80" alt="Lapor Tanam" style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                <h3>Lapor Tanam</h3>
                <p class="bio">Input data tanam langsung memperbarui grafik distribusi desa. Petani aktif dapat prioritas armada truk.</p>
                <span class="btn btn-primary" style="margin-top:8px; display:inline-block; font-size:.85rem;">Lapor Sekarang</span>
            </a>
        </div>
    </div>
</section>

<!-- Team Section -->
<section id="team" class="section team">
    <div class="container">
        <div class="section-header">
            <h2>Anggota Tim</h2>
            <p>Berkenalan dengan para kontributor di balik proyek ini</p>
        </div>
        <div class="grid grid-team">
            @foreach ($members as $member)
                <div class="card card-member">
                    <img src="{{ $member['avatar'] }}" alt="{{ $member['name'] }}" class="avatar">
                    <h3>{{ $member['name'] }}</h3>
                    <span class="role">{{ $member['role'] }}</span>
                    <p class="bio">{{ $member['bio'] }}</p>
                    
                    <div class="skills">
                        @foreach ($member['skills'] as $skill)
                            <span class="badge">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Projects Section -->
<section id="projects" class="section projects">
    <div class="container">
        <div class="section-header">
            <h2>Proyek Terbaru</h2>
            <p>Daftar hasil karya dan proyek yang telah kami selesaikan</p>
        </div>
        <div class="grid grid-projects">
            @foreach ($projects as $project)
                <div class="card card-project">
                    <div class="project-img-wrapper">
                        <img src="{{ $project['image'] }}" alt="{{ $project['title'] }}">
                    </div>
                    <div class="project-body">
                        <span class="category">{{ $project['category'] }}</span>
                        <h3>{{ $project['title'] }}</h3>
                        <p>{{ $project['description'] }}</p>
                        <a href="{{ $project['link'] }}" class="project-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="section contact">
    <div class="container">
        <div class="section-header">
            <h2>Kirim Pesan</h2>
            <p>Ingin berdiskusi atau bekerja sama dengan kami?</p>
        </div>
        <form class="contact-form" action="" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="name" placeholder="Nama Lengkap" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Alamat Email" required>
            </div>
            <div class="form-group">
                <textarea name="message" rows="5" placeholder="Pesan Anda" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Kirim Pesan</button>
        </form>
    </div>
</section>
@endsection