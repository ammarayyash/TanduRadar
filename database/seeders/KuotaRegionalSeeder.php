<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KuotaRegional;

class KuotaRegionalSeeder extends Seeder
{
    public function run(): void
    {
        $kecamatans = ['Kecamatan Sukamaju', 'Kecamatan Harapan', 'Kecamatan Mekar'];

        $kuotas = [
            ['komoditas' => 'Cabai Rawit',  'persen_max' => 40.00, 'deskripsi' => 'Risiko oversupply tinggi di atas 40%'],
            ['komoditas' => 'Cabai Merah',  'persen_max' => 35.00, 'deskripsi' => 'Volatilitas harga sangat tinggi'],
            ['komoditas' => 'Tomat',         'persen_max' => 30.00, 'deskripsi' => 'Umur simpan pendek, mudah busuk'],
            ['komoditas' => 'Buncis',        'persen_max' => 50.00, 'deskripsi' => 'Permintaan stabil, risiko rendah'],
            ['komoditas' => 'Timun',         'persen_max' => 50.00, 'deskripsi' => 'Siklus panen cepat, relatif aman'],
            ['komoditas' => 'Kangkung',      'persen_max' => 60.00, 'deskripsi' => 'Permintaan pasar tinggi & stabil'],
            ['komoditas' => 'Bayam',         'persen_max' => 55.00, 'deskripsi' => 'Cocok untuk diversifikasi'],
            ['komoditas' => 'Jagung Manis',  'persen_max' => 45.00, 'deskripsi' => 'Pasar luas, risiko moderat'],
        ];

        foreach ($kecamatans as $kecamatan) {
            foreach ($kuotas as $kuota) {
                KuotaRegional::firstOrCreate(
                    ['kecamatan' => $kecamatan, 'komoditas' => $kuota['komoditas']],
                    ['persen_max' => $kuota['persen_max'], 'deskripsi' => $kuota['deskripsi']]
                );
            }
        }
    }
}
