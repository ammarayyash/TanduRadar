<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LahanActivity;
use Carbon\Carbon;

class LahanActivitySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Kecamatan Sukamaju — banyak Cabai Rawit (akan menjadi MERAH)
            ['nama_petani' => 'Pak Suwarno',   'komoditas' => 'Cabai Rawit', 'kecamatan' => 'Kecamatan Sukamaju', 'desa' => 'Desa Suka Damai',   'luas_lahan' => 0.8, 'hari_tanam' => -14, 'panen_hari' => 80, 'tonase' => 2.4],
            ['nama_petani' => 'Bu Kartini',    'komoditas' => 'Cabai Rawit', 'kecamatan' => 'Kecamatan Sukamaju', 'desa' => 'Desa Suka Damai',   'luas_lahan' => 1.2, 'hari_tanam' => -7,  'panen_hari' => 85, 'tonase' => 3.6],
            ['nama_petani' => 'Pak Jatmiko',   'komoditas' => 'Cabai Rawit', 'kecamatan' => 'Kecamatan Sukamaju', 'desa' => 'Desa Maju Bersama', 'luas_lahan' => 1.0, 'hari_tanam' => -5,  'panen_hari' => 82, 'tonase' => 3.0],
            ['nama_petani' => 'Bu Sariningsih','komoditas' => 'Cabai Rawit', 'kecamatan' => 'Kecamatan Sukamaju', 'desa' => 'Desa Maju Bersama', 'luas_lahan' => 0.6, 'hari_tanam' => -10, 'panen_hari' => 78, 'tonase' => 1.8],
            ['nama_petani' => 'Pak Bambang',   'komoditas' => 'Tomat',       'kecamatan' => 'Kecamatan Sukamaju', 'desa' => 'Desa Suka Damai',   'luas_lahan' => 0.5, 'hari_tanam' => -20, 'panen_hari' => 60, 'tonase' => 2.0],
            ['nama_petani' => 'Bu Rahayu',     'komoditas' => 'Kangkung',    'kecamatan' => 'Kecamatan Sukamaju', 'desa' => 'Desa Mekar Sari',   'luas_lahan' => 0.3, 'hari_tanam' => -3,  'panen_hari' => 30, 'tonase' => 0.9],
            // Kecamatan Harapan — beragam, status KUNING-HIJAU
            ['nama_petani' => 'Pak Hendra',    'komoditas' => 'Tomat',       'kecamatan' => 'Kecamatan Harapan', 'desa' => 'Desa Harapan Jaya',  'luas_lahan' => 0.9, 'hari_tanam' => -15, 'panen_hari' => 65, 'tonase' => 3.5],
            ['nama_petani' => 'Bu Dewi',       'komoditas' => 'Buncis',      'kecamatan' => 'Kecamatan Harapan', 'desa' => 'Desa Harapan Jaya',  'luas_lahan' => 1.0, 'hari_tanam' => -8,  'panen_hari' => 58, 'tonase' => 2.0],
            ['nama_petani' => 'Pak Gunawan',   'komoditas' => 'Timun',       'kecamatan' => 'Kecamatan Harapan', 'desa' => 'Desa Sejahtera',     'luas_lahan' => 0.7, 'hari_tanam' => -12, 'panen_hari' => 45, 'tonase' => 2.1],
            ['nama_petani' => 'Bu Mutia',      'komoditas' => 'Jagung Manis','kecamatan' => 'Kecamatan Harapan', 'desa' => 'Desa Sejahtera',     'luas_lahan' => 1.5, 'hari_tanam' => -20, 'panen_hari' => 90, 'tonase' => 4.5],
            // Kecamatan Mekar — sedikit aktivitas, banyak HIJAU
            ['nama_petani' => 'Pak Slamet',    'komoditas' => 'Bayam',       'kecamatan' => 'Kecamatan Mekar', 'desa' => 'Desa Mekar Indah',    'luas_lahan' => 0.4, 'hari_tanam' => -2,  'panen_hari' => 25, 'tonase' => 0.8],
            ['nama_petani' => 'Bu Lastri',     'komoditas' => 'Kangkung',    'kecamatan' => 'Kecamatan Mekar', 'desa' => 'Desa Mekar Indah',    'luas_lahan' => 0.3, 'hari_tanam' => -5,  'panen_hari' => 28, 'tonase' => 0.6],
        ];

        foreach ($data as $row) {
            LahanActivity::create([
                'nama_petani'     => $row['nama_petani'],
                'komoditas'       => $row['komoditas'],
                'kecamatan'       => $row['kecamatan'],
                'desa'            => $row['desa'],
                'luas_lahan'      => $row['luas_lahan'],
                'tanggal_tanam'   => Carbon::now()->addDays($row['hari_tanam']),
                'estimasi_panen'  => Carbon::now()->addDays($row['panen_hari']),
                'estimasi_tonase' => $row['tonase'],
                'status'          => 'aktif',
            ]);
        }
    }
}
