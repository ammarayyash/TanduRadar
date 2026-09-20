@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container hero-content">
        <span class="tag-green"><i class="fas fa-truck"></i> Modul C — Eco-Logistik</span>
        <h1>Jadwal Panen & <span>Armada Truk</span></h1>
        <p>Koordinasi logistik tanpa bottleneck. Pantau jadwal panen desa dan dampak lingkungan rotasi tanam.</p>
        <div class="hero-buttons">
            <a href="{{ route('lapor-tanam') }}" class="btn btn-primary">Lapor Tanam</a>
            <a href="{{ route('mata-desa') }}" class="btn btn-secondary">Lihat Mata Desa</a>
        </div>
    </div>
</section>

<section class="section" style="padding-top:100px;">
    <div class="container">
        <!-- Filter -->
        <div class="filter-bar">
            <label style="color:var(--text-muted); font-size:.9rem">Kecamatan:</label>
            <form method="GET" action="{{ route('logistik') }}" style="display:flex;gap:10px;align-items:center">
                <select name="kecamatan" onchange="this.form.submit()">
                    @foreach($kecamatanList as $kec)
                        <option value="{{ $kec }}" {{ $kec === $kecamatan ? 'selected' : '' }}>{{ $kec }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Tracker Sayur Terselamatkan -->
        <div class="section-header">
            <h2>🌍 Tracker Dampak Lingkungan</h2>
            <p>Estimasi kontribusi positif sistem rotasi TanduRadar di {{ $kecamatan }}</p>
        </div>

        <div class="stats-bar" style="margin-bottom:50px;">
            <div class="stat-item" style="border-color:var(--status-hijau)">
                <span class="stat-number" style="color:var(--status-hijau)">{{ $sayurTerselamatkan }} Ton</span>
                <div class="stat-label">🥬 Sayur Terselamatkan dari Pembusukan</div>
            </div>
            <div class="stat-item" style="border-color:var(--status-hijau)">
                <span class="stat-number" style="color:var(--status-hijau)">{{ $co2Dihemat }} Ton</span>
                <div class="stat-label">☁️ CO₂ yang Dihindari</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ number_format($totalTonase, 1) }} Ton</span>
                <div class="stat-label">📦 Total Estimasi Panen Aktif</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $jadwalPanen->count() }}</span>
                <div class="stat-label">🚜 Lahan Panen dalam 30 Hari</div>
            </div>
        </div>

        <!-- Papan Jadwal Panen Desa -->
        <div class="section-header">
            <h2>📋 Papan Jadwal Panen Desa</h2>
            <p>Jadwal panen aktif 30 hari ke depan di {{ $kecamatan }} — untuk koordinasi armada truk/pickup</p>
        </div>

        @if($jadwalPanen->isEmpty())
            <div class="card" style="text-align:center; padding:50px 20px;">
                <p style="font-size:2rem">🚛</p>
                <h3>Tidak ada jadwal panen dalam 30 hari ke depan</h3>
                <p style="color:var(--text-muted)">Data jadwal panen akan muncul setelah petani melaporkan aktivitas tanam.</p>
                <a href="{{ route('lapor-tanam') }}" class="btn btn-primary" style="margin-top:16px">Lapor Tanam</a>
            </div>
        @else
            @foreach($jadwalPerMinggu as $minggu => $lahan)
            <div class="card" style="margin-bottom:20px;">
                <h4 style="color:var(--primary); margin-bottom:16px; font-size:1rem;">
                    <i class="fas fa-calendar-week"></i> {{ $minggu }}
                    <span style="font-size:.8rem; color:var(--text-muted); font-weight:400; margin-left:8px;">
                        ({{ $lahan->count() }} lahan — total {{ number_format($lahan->sum('estimasi_tonase'),1) }} ton)
                    </span>
                </h4>
                <div style="overflow-x:auto">
                    <table class="jadwal-table">
                        <thead>
                            <tr>
                                <th>Petani</th>
                                <th>Komoditas</th>
                                <th>Desa</th>
                                <th>Luas (Ha)</th>
                                <th>Est. Tonase</th>
                                <th>Tanggal Panen</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lahan as $item)
                            @php
                                $hariLagi = now()->diffInDays($item->estimasi_panen, false);
                                $urgent   = $hariLagi <= 7;
                            @endphp
                            <tr>
                                <td><strong>{{ $item->nama_petani }}</strong></td>
                                <td>{{ $item->komoditas }}</td>
                                <td>{{ $item->desa }}</td>
                                <td>{{ $item->luas_lahan }} Ha</td>
                                <td>{{ $item->estimasi_tonase }} ton</td>
                                <td>
                                    {{ $item->estimasi_panen->format('d M Y') }}
                                    @if($urgent)
                                        <span class="badge badge-kuning" style="font-size:.7rem; margin-left:4px;">H-{{ $hariLagi }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $urgent ? 'badge-kuning' : 'badge-hijau' }}" style="font-size:.75rem;">
                                        {{ $urgent ? '🔔 Segera' : '✅ Terjadwal' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach

            <div class="card" style="text-align:center; padding:20px; border-style:dashed;">
                <p style="color:var(--text-muted); font-size:.9rem; margin:0;">
                    <i class="fas fa-info-circle"></i>
                    Supir truk/pickup dapat mengakses papan ini untuk mengatur jadwal penjemputan logistik
                    tanpa <em>bottleneck</em> saat panen raya.
                </p>
            </div>
        @endif
    </div>
</section>
@endsection
