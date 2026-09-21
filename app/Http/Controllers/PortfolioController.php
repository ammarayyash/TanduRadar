<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $data = [
            'group_name'    => 'TanduRadar',
            'group_title'   => 'TanduRadar - Portofolio Kelompok 10',
            'hero_title'    => 'Proyek TanduRadar',
            'hero_subtitle' => 'Platform manajemen rotasi tanam berbasis komunitas. "Tandur" (menanam) & "Radar" (pendeteksi). Alat untuk mendeteksi apa yang sedang ditanam oleh tetangga di desamu guna mencegah oversupply.',
            'members'       => [
                [
                    'name'   => 'Muhammad Ammar Ayyash',
                    'role'   => 'Perancang Sistem & Pencari Data',
                    'bio'    => 'Merancang arsitektur sistem basis data dan mengumpulkan data komoditas pertanian.',
                    'avatar' => asset('images/ammar.jpg'),
                    'skills' => ['Sistem Arsitektur', 'Analisis Data', 'Laravel'],
                ],
                [
                    'name'   => 'Muhammal Al-Ayubi',
                    'role'   => 'UI/UX & Perancang Alur',
                    'bio'    => 'Mendesain antarmuka aplikasi dan menyusun alur penggunaan (user flow) agar mudah digunakan petani.',
                    'avatar' => asset('images/ayubi.png'),
                    'skills' => ['UI/UX Design', 'User Flow', 'Frontend'],
                ],
            ],
            'projects' => [
                [
                    'title'       => 'TanduRadar - Sistem Rotasi Tanam',
                    'category'    => 'AgriTech / Web Application',
                    'description' => 'Platform crowdsourced data untuk memutus siklus "Panen Raya Berdarah" dengan early warning oversupply berbasis data petani real-time.',
                    'image'       => 'https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?w=600&q=80',
                    'link'        => route('mata-desa'),
                ],
                [
                    'title'       => 'Modul Rekomendasi Cerdas',
                    'category'    => 'Algoritma & Data Processing',
                    'description' => 'Sistem rekomendasi komoditas alternatif dengan kalkulator simulasi keuntungan berbasis data historis kuota regional.',
                    'image'       => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&q=80',
                    'link'        => route('rekomendasi'),
                ],
                [
                    'title'       => 'Eco-Logistik & Jadwal Panen',
                    'category'    => 'Logistik & Lingkungan',
                    'description' => 'Papan jadwal panen digital untuk koordinasi armada truk dan tracker dampak lingkungan (food waste prevention).',
                    'image'       => 'https://images.unsplash.com/photo-1586771107445-d3ca888129ff?w=600&q=80',
                    'link'        => route('logistik'),
                ],
            ],
        ];

        return view('portfolio', $data);
    }
}
