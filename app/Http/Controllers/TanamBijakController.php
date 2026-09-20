<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LahanActivity;
use App\Models\KuotaRegional;
use Illuminate\Support\Facades\DB;

class TanamBijakController extends Controller
{
    // ─────────────────────────────────────────────
    //  Data bersama (dipakai di semua halaman)
    // ─────────────────────────────────────────────
    private array $sharedData;
    private string $defaultKecamatan = 'Kecamatan Sukamaju';

    public function __construct()
    {
        $this->sharedData = [
            'group_name'  => 'TanduRadar',
            'group_title' => 'TanduRadar – Sistem Manajemen Rotasi Tanam',
        ];
    }

    // ─────────────────────────────────────────────
    //  Modul A – Mata Desa
    // ─────────────────────────────────────────────
    public function mataDesa(Request $request)
    {
        $kecamatan = $request->get('kecamatan', $this->defaultKecamatan);

        // Hitung total luas semua komoditas di kecamatan tersebut
        $totalLuas = (float) LahanActivity::where('kecamatan', $kecamatan)
            ->where('status', 'aktif')
            ->sum('luas_lahan');

        // Agregasi per komoditas
        $dataKomoditas = LahanActivity::where('kecamatan', $kecamatan)
            ->where('status', 'aktif')
            ->select('komoditas', DB::raw('SUM(luas_lahan) as total_luas'), DB::raw('COUNT(*) as jumlah_petani'))
            ->groupBy('komoditas')
            ->get()
            ->map(function ($item) use ($kecamatan, $totalLuas) {
                $kuota      = (float) KuotaRegional::getKuota($kecamatan, $item->komoditas);
                $persen     = $totalLuas > 0 ? round(((float)$item->total_luas / $totalLuas) * 100, 1) : 0;
                $rasio      = $kuota > 0 ? ($persen / $kuota) : 0;
                $item->persen        = $persen;
                $item->kuota_max     = $kuota;
                $item->status        = $rasio >= 1 ? 'merah' : ($rasio >= 0.7 ? 'kuning' : 'hijau');
                $item->status_label  = $rasio >= 1 ? '🔴 Risiko Tinggi' : ($rasio >= 0.7 ? '🟡 Mendekati Jenuh' : '🟢 Peluang Besar');
                return $item;
            });

        $kecamatanList = LahanActivity::select('kecamatan')
            ->distinct()->pluck('kecamatan');

        return view('tanambijak.mata-desa', array_merge($this->sharedData, compact(
            'kecamatan', 'kecamatanList', 'dataKomoditas', 'totalLuas'
        )));
    }

    // ─────────────────────────────────────────────
    //  Modul B – Rekomendasi Cerdas
    // ─────────────────────────────────────────────
    public function rekomendasi(Request $request)
    {
        $kecamatan = $request->get('kecamatan', $this->defaultKecamatan);

        // Komoditas berstatus merah (berbahaya)
        $totalLuas = (float) LahanActivity::where('kecamatan', $kecamatan)
            ->where('status', 'aktif')->sum('luas_lahan');

        $komoditasMerah = LahanActivity::where('kecamatan', $kecamatan)
            ->where('status', 'aktif')
            ->select('komoditas', DB::raw('SUM(luas_lahan) as total_luas'))
            ->groupBy('komoditas')
            ->get()
            ->filter(function ($item) use ($totalLuas, $kecamatan) {
                $persen = $totalLuas > 0 ? ((float)$item->total_luas / $totalLuas) * 100 : 0;
                $kuota  = (float) KuotaRegional::getKuota($kecamatan, $item->komoditas);
                return $persen >= $kuota;
            })
            ->pluck('komoditas');

        // Komoditas hijau (peluang)
        $komoditasHijau = LahanActivity::where('kecamatan', $kecamatan)
            ->where('status', 'aktif')
            ->select('komoditas', DB::raw('SUM(luas_lahan) as total_luas'))
            ->groupBy('komoditas')
            ->get()
            ->filter(function ($item) use ($totalLuas, $kecamatan) {
                $persen = $totalLuas > 0 ? ((float)$item->total_luas / $totalLuas) * 100 : 0;
                $kuota  = (float) KuotaRegional::getKuota($kecamatan, $item->komoditas);
                return $persen < ($kuota * 0.6);
            })
            ->pluck('komoditas');

        // Panduan tanaman alternatif
        $alternatif = [
            ['nama' => 'Buncis',       'masa_panen' => 55,  'keuntungan' => '+18%', 'icon' => '🫘', 'tips' => 'Tanah gembur pH 6-7, siram rutin setiap 2 hari.'],
            ['nama' => 'Timun',        'masa_panen' => 45,  'keuntungan' => '+22%', 'icon' => '🥒', 'tips' => 'Butuh sinar matahari penuh, drainase baik.'],
            ['nama' => 'Kangkung',     'masa_panen' => 28,  'keuntungan' => '+15%', 'icon' => '🌿', 'tips' => 'Panen cepat, cocok untuk rotasi singkat.'],
            ['nama' => 'Bayam',        'masa_panen' => 25,  'keuntungan' => '+12%', 'icon' => '🥬', 'tips' => 'Tahan cuaca, pasar lokal selalu ada.'],
            ['nama' => 'Jagung Manis', 'masa_panen' => 90,  'keuntungan' => '+25%', 'icon' => '🌽', 'tips' => 'Margin tinggi, cocok untuk skala besar.'],
        ];

        $kecamatanList = LahanActivity::select('kecamatan')->distinct()->pluck('kecamatan');

        return view('tanambijak.rekomendasi', array_merge($this->sharedData, compact(
            'kecamatan', 'kecamatanList', 'komoditasMerah', 'komoditasHijau', 'alternatif'
        )));
    }

    // ─────────────────────────────────────────────
    //  Modul C – Eco-Logistik
    // ─────────────────────────────────────────────
    public function logistik(Request $request)
    {
        $kecamatan = $request->get('kecamatan', $this->defaultKecamatan);

        // Jadwal panen dalam 30 hari ke depan
        $jadwalPanen = LahanActivity::where('kecamatan', $kecamatan)
            ->where('status', 'aktif')
            ->whereBetween('estimasi_panen', [now(), now()->addDays(30)])
            ->orderBy('estimasi_panen')
            ->get();

        // Estimasi tonase yang terselamatkan (vs skenario tanpa rotasi)
        $totalTonase = (float) LahanActivity::where('kecamatan', $kecamatan)
            ->where('status', 'aktif')
            ->sum('estimasi_tonase');

        // Asumsi: 35% tonase terselamatkan dari pembusukan karena rotasi
        $sayurTerselamatkan = round($totalTonase * 0.35, 1);
        $co2Dihemat         = round($sayurTerselamatkan * 2.5, 1); // 2.5 kg CO2 / kg

        // Kelompokkan jadwal per minggu
        $jadwalPerMinggu = $jadwalPanen->groupBy(function ($item) {
            return 'Minggu ke-' . $item->estimasi_panen->weekOfYear;
        });

        $kecamatanList = LahanActivity::select('kecamatan')->distinct()->pluck('kecamatan');

        return view('tanambijak.logistik', array_merge($this->sharedData, compact(
            'kecamatan', 'kecamatanList', 'jadwalPanen', 'jadwalPerMinggu',
            'sayurTerselamatkan', 'co2Dihemat', 'totalTonase'
        )));
    }

    // ─────────────────────────────────────────────
    //  Lapor Tanam — Form & Store
    // ─────────────────────────────────────────────
    public function laporTanam()
    {
        $komoditasList = [
            'Cabai Rawit', 'Cabai Merah', 'Tomat', 'Buncis',
            'Timun', 'Kangkung', 'Bayam', 'Jagung Manis',
        ];
        $kecamatanList = [
            'Kecamatan Sukamaju', 'Kecamatan Harapan', 'Kecamatan Mekar',
        ];

        // Estimasi hari panen per komoditas (untuk kalkulasi otomatis)
        $masaPanenMap = [
            'Cabai Rawit'  => 80, 'Cabai Merah' => 85, 'Tomat'    => 65,
            'Buncis'       => 55, 'Timun'       => 45, 'Kangkung' => 28,
            'Bayam'        => 25, 'Jagung Manis' => 90,
        ];

        return view('tanambijak.lapor-tanam', array_merge($this->sharedData, compact(
            'komoditasList', 'kecamatanList', 'masaPanenMap'
        )));
    }

    public function storeLaporTanam(Request $request)
    {
        $validated = $request->validate([
            'nama_petani'    => 'required|string|max:100',
            'komoditas'      => 'required|string',
            'desa'           => 'required|string|max:100',
            'kecamatan'      => 'required|string|max:100',
            'luas_lahan'     => 'required|numeric|min:0.01|max:100',
            'tanggal_tanam'  => 'required|date',
            'estimasi_panen' => 'required|date|after:tanggal_tanam',
            'estimasi_tonase'=> 'nullable|numeric|min:0',
        ]);

        LahanActivity::create(array_merge($validated, ['status' => 'aktif']));

        return redirect()->route('mata-desa')
            ->with('success', '✅ Data tanam berhasil dilaporkan! Grafik desa telah diperbarui.');
    }
}
