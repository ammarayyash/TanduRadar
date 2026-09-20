# RANCANGAN SISTEM APLIKASI: "TanamBijak"
*Platform Manajemen Rotasi Tanam & Pencegahan Oversupply Pertanian*

## 1. Ringkasan Konsep (Executive Summary)
**TanamBijak** adalah aplikasi berbasis komunitas (peer-to-peer data) yang dirancang untuk memutus siklus "Panen Raya Berdarah" (*Cobweb Theorem*) pada komoditas rentan seperti Cabai dan Tomat. Dengan memetakan apa yang ditanam oleh petani dalam satu kawasan secara *real-time*, sistem ini memberikan peringatan dini (*early warning*) terhadap potensi *oversupply*, menyarankan komoditas alternatif, mencegah limbah pangan (*food waste*), dan menstabilkan rantai logistik desa.

## 2. Arsitektur Sistem (High-Level Design)
Sistem ini beroperasi dengan model **Crowdsourced Data Processing**:
*   **INPUT:** Petani memasukkan data sederhana (Jenis tanaman, Luas lahan, Tanggal tanam).
*   **PROSES:** Algoritma sistem mengagregasi data desa/kecamatan, membandingkannya dengan kuota aman historis, dan memproyeksikan estimasi volume panen di masa depan.
*   **OUTPUT:** UI Dasbor Status Lahan, Peringatan Bahaya (Merah/Kuning/Hijau), dan Rekomendasi Tanaman Alternatif.

## 3. Modul dan Fitur Utama

### A. Modul "Mata Desa" (Visualisasi Data Tetangga)
*   **Fungsi:** Menghilangkan asimetri informasi di tingkat desa/kecamatan.
*   **UI/UX:** 
    *   Grafik Donat / Bar Chart anonim. 
    *   **Contoh Copywriting:** *"Saat ini 65% lahan di Kecamatan Anda ditanami Cabai Rawit. Kuota aman: Maksimal 40%."*
    *   **Indikator Warna:** Merah (Risiko anjlok sangat tinggi), Kuning (Mendekati jenuh), Hijau (Kekurangan suplai, peluang untung besar).

### B. Modul Kalender Rotasi & Rekomendasi Cerdas
*   **Fungsi:** Mengarahkan petani ke tanaman alternatif saat komoditas utama berstatus "Merah".
*   **UI/UX:**
    *   Kalkulator Simulasi Sederhana.
    *   **Contoh Copywriting:** *"Hindari Tomat musim ini! Coba tanam Buncis atau Timun. Estimasi masa panen: 60 hari. Estimasi profit lebih tinggi 20% dibanding risiko Tomat saat ini."*
    *   Tautan ke panduan singkat cara menanam komoditas alternatif tersebut.

### C. Modul "Eco-Logistik" (Integrasi Lingkungan & Transportasi)
*   **Fungsi:** Menampilkan dampak positif rotasi tanam secara praktis kepada petani.
*   **Fitur Lingkungan (Pencegahan Food Waste):** 
    *   Tracker "Sayur Terselamatkan". Menampilkan estimasi berapa ton sayur yang dicegah dari kebusukan di selokan/jalan karena menghindari *oversupply*.
*   **Fitur Transportasi (Penjadwalan Truk):**
    *   Karena jadwal tanam terdistribusi (tidak serentak), sistem menyediakan **Papan Jadwal Panen Desa**.
    *   Supir truk/pikap lokal bisa mengakses dasbor ini untuk mengatur jadwal penjemputan logistik tanpa *bottleneck* (kemacetan atau kekurangan armada saat panen raya).

## 4. Alur Pengguna (User Flow - Petani)
1.  **Onboarding:** Petani mendaftar, memasukkan lokasi lahan (Desa/Kecamatan) dan luas lahan perkiraan.
2.  **Cek Kondisi (Fase Pra-Tanam):** Sebelum menyemai bibit, petani membuka aplikasi untuk melihat "Status Lahan Desa".
3.  **Pengambilan Keputusan:** 
    *   Jika status **Hijau**, petani lanjut menanam komoditas awal.
    *   Jika status **Merah**, petani melihat "Rekomendasi Cerdas" dan beralih ke tanaman alternatif.
4.  **Lapor Tanam:** Petani menekan tombol *"Saya mulai tanam [Jenis Tanaman] hari ini"*. (Data ini langsung memperbarui grafik desa secara *real-time*).
5.  **Fase Menunggu Panen:** Aplikasi mengirimkan pengingat perawatan sesekali, dan memberikan notifikasi persiapan logistik/truk menjelang H-7 panen.

## 5. Strategi Retensi (Mengapa Petani Mau Mengisi Data?)
Agar sistem berjalan, data input harus rutin. Sistem menggunakan pendekatan insentif:
*   **Akses Eksklusif Armada Transportasi:** Petani yang rutin melapor jadwal tanamnya akan masuk dalam daftar prioritas (VIP) untuk pemesanan armada truk/pikap saat panen nanti melalui Modul Logistik.
*   **Lencana Komunitas:** Label "Petani Cerdas" atau "Penyelamat Harga" bagi mereka yang mau beralih ke komoditas alternatif saat status sedang merah.

## 6. Kebutuhan Struktur Data (Database)
*   **Tabel Pengguna:** ID Petani, Nama, Lokasi (Desa/Kecamatan), Luas Lahan (Total).
*   **Tabel Aktivitas Lahan:** ID Lahan, Jenis Komoditas, Tanggal Tanam, Estimasi Tanggal Panen, Estimasi Tonase.
*   **Tabel Kuota Regional:** Batas aman persentase lahan per komoditas per daerah (Misal: Tomat maks 30% dari total lahan desa).