<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container hero-content">
        <span class="tag-green"><i class="fas fa-seedling"></i> Modul A — Mata Desa</span>
        <h1>Status Lahan <span><?php echo e($kecamatan); ?></span></h1>
        <p>Pantau distribusi komoditas di kawasanmu secara real-time. Cegah oversupply sebelum terjadi.</p>
        <div class="hero-buttons">
            <a href="<?php echo e(route('lapor-tanam')); ?>" class="btn btn-primary">Lapor Tanam Sekarang</a>
            <a href="<?php echo e(route('rekomendasi')); ?>" class="btn btn-secondary">Lihat Rekomendasi</a>
        </div>
    </div>
</section>

<!-- Filter Kecamatan -->
<section class="section" style="padding-top: 100px; padding-bottom: 20px;">
    <div class="container">
        <?php if(session('success')): ?>
            <div class="flash-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <div class="filter-bar">
            <label style="color:var(--text-muted); font-size:.9rem">Pilih Kecamatan:</label>
            <form method="GET" action="<?php echo e(route('mata-desa')); ?>" style="display:flex;gap:10px;align-items:center">
                <select name="kecamatan" onchange="this.form.submit()">
                    <?php $__currentLoopData = $kecamatanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($kec); ?>" <?php echo e($kec === $kecamatan ? 'selected' : ''); ?>><?php echo e($kec); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </form>
        </div>

        <!-- Stats Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-number"><?php echo e($dataKomoditas->count()); ?></span>
                <div class="stat-label">Jenis Komoditas</div>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo e(number_format($totalLuas, 1)); ?> Ha</span>
                <div class="stat-label">Total Lahan Aktif</div>
            </div>
            <div class="stat-item">
                <span class="stat-number" style="color:var(--status-merah)"><?php echo e($dataKomoditas->where('status','merah')->count()); ?></span>
                <div class="stat-label">Komoditas Risiko Tinggi</div>
            </div>
            <div class="stat-item">
                <span class="stat-number" style="color:var(--status-hijau)"><?php echo e($dataKomoditas->where('status','hijau')->count()); ?></span>
                <div class="stat-label">Peluang Tersedia</div>
            </div>
        </div>
    </div>
</section>

<!-- Data Komoditas Section -->
<section class="section" style="padding-top: 20px;">
    <div class="container">
        <div class="section-header">
            <h2>Distribusi Komoditas</h2>
            <p>Persentase lahan yang ditanami vs. kuota aman per komoditas</p>
        </div>

        <?php if($dataKomoditas->isEmpty()): ?>
            <div class="card" style="text-align:center; padding: 50px 20px;">
                <p style="font-size:2rem">🌱</p>
                <h3>Belum ada data lahan aktif</h3>
                <p style="color:var(--text-muted)">Jadilah yang pertama melaporkan aktivitas tanam di kecamatan ini!</p>
                <a href="<?php echo e(route('lapor-tanam')); ?>" class="btn btn-primary" style="margin-top:16px">Lapor Tanam</a>
            </div>
        <?php else: ?>
            <div class="grid grid-projects">
                <?php $__currentLoopData = $dataKomoditas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $fillClass = 'fill-' . $item->status;
                        $badgeClass = 'badge-' . $item->status;
                        $barWidth = min(100, round(($item->persen / $item->kuota_max) * 100));
                    ?>
                    <div class="card">
                        <div class="komoditas-row">
                            <span><?php echo e($item->komoditas); ?></span>
                            <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($item->status_label); ?></span>
                        </div>

                        <!-- Progress bar: persen aktual vs kuota max -->
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill <?php echo e($fillClass); ?>" style="width: <?php echo e($barWidth); ?>%"></div>
                        </div>

                        <div style="display:flex; justify-content:space-between; font-size:.82rem; color:var(--text-muted); margin-top:4px;">
                            <span>Saat ini: <strong style="color:var(--text-main)"><?php echo e($item->persen); ?>%</strong> lahan</span>
                            <span>Kuota aman: maks <strong style="color:var(--text-main)"><?php echo e($item->kuota_max); ?>%</strong></span>
                        </div>

                        <hr style="border-color:var(--border); margin: 12px 0;">

                        <div style="display:flex; justify-content:space-between; font-size:.85rem;">
                            <span style="color:var(--text-muted)">Total lahan</span>
                            <span><?php echo e(number_format($item->total_luas, 2)); ?> Ha</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:.85rem; margin-top:6px;">
                            <span style="color:var(--text-muted)">Jumlah petani</span>
                            <span><?php echo e($item->jumlah_petani); ?> orang</span>
                        </div>

                        <?php if($item->status === 'merah'): ?>
                            <div style="margin-top:14px; padding:10px 14px; background:rgba(239,68,68,.1); border-radius:8px; font-size:.83rem; color:var(--status-merah);">
                                <strong>⚠️ Peringatan:</strong> <?php echo e($item->persen); ?>% lahan ditanami <?php echo e($item->komoditas); ?>. Kuota aman: maks <?php echo e($item->kuota_max); ?>%. <a href="<?php echo e(route('rekomendasi', ['kecamatan' => $kecamatan])); ?>" style="color:var(--status-merah); text-decoration:underline;">Lihat Alternatif →</a>
                            </div>
                        <?php elseif($item->status === 'kuning'): ?>
                            <div style="margin-top:14px; padding:10px 14px; background:rgba(245,158,11,.1); border-radius:8px; font-size:.83rem; color:var(--status-kuning);">
                                <strong>🔔 Mendekati jenuh.</strong> Pertimbangkan tanaman lain saat musim berikutnya.
                            </div>
                        <?php else: ?>
                            <div style="margin-top:14px; padding:10px 14px; background:rgba(34,197,94,.1); border-radius:8px; font-size:.83rem; color:var(--status-hijau);">
                                <strong>✅ Peluang bagus!</strong> Kekurangan suplai — estimasi profit lebih tinggi.
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Copywriting informatif -->
            <div class="card" style="margin-top:30px; text-align:center;">
                <p style="font-size:1rem; color:var(--text-muted); font-style:italic;">
                    "Saat ini <strong style="color:var(--text-main)"><?php echo e($dataKomoditas->first()->persen); ?>% lahan</strong>
                    di <?php echo e($kecamatan); ?> ditanami <strong style="color:var(--text-main)"><?php echo e($dataKomoditas->first()->komoditas); ?></strong>.
                    Kuota aman: Maksimal <strong style="color:var(--text-main)"><?php echo e($dataKomoditas->first()->kuota_max); ?>%</strong>."
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Ammar\Kelompok 10\resources\views/tanambijak/mata-desa.blade.php ENDPATH**/ ?>