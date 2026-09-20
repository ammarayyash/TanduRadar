<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container hero-content">
        <span class="tag-green"><i class="fas fa-lightbulb"></i> Modul B — Rekomendasi Cerdas</span>
        <h1>Pilih Tanaman <span>yang Tepat</span></h1>
        <p>Jangan tanam komoditas yang sedang jenuh. Sistem akan mengarahkan kamu ke peluang terbaik musim ini.</p>
        <div class="hero-buttons">
            <a href="<?php echo e(route('lapor-tanam')); ?>" class="btn btn-primary">Lapor Tanam</a>
            <a href="<?php echo e(route('mata-desa')); ?>" class="btn btn-secondary">Lihat Mata Desa</a>
        </div>
    </div>
</section>

<section class="section" style="padding-top:100px;">
    <div class="container">
        <!-- Filter -->
        <div class="filter-bar">
            <label style="color:var(--text-muted); font-size:.9rem">Kecamatan:</label>
            <form method="GET" action="<?php echo e(route('rekomendasi')); ?>" style="display:flex;gap:10px;align-items:center">
                <select name="kecamatan" onchange="this.form.submit()">
                    <?php $__currentLoopData = $kecamatanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($kec); ?>" <?php echo e($kec === $kecamatan ? 'selected' : ''); ?>><?php echo e($kec); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </form>
        </div>

        <!-- Status Peringatan -->
        <?php if($komoditasMerah->isNotEmpty()): ?>
        <div class="card" style="border-color:var(--status-merah); margin-bottom:30px;">
            <h3 style="color:var(--status-merah); margin-bottom: 10px;">⛔ Hindari Musim Ini di <?php echo e($kecamatan); ?></h3>
            <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:14px;">
                <?php $__currentLoopData = $komoditasMerah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="badge badge-merah" style="font-size:.9rem; padding:6px 14px;"><?php echo e($k); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <p style="font-size:.88rem; color:var(--text-muted); margin:0;">
                "Hindari <?php echo e($komoditasMerah->first()); ?> musim ini! Lahan jenuh — risiko anjlok harga sangat tinggi. Pertimbangkan alternatif di bawah."
            </p>
        </div>
        <?php endif; ?>

        <?php if($komoditasHijau->isNotEmpty()): ?>
        <div class="card" style="border-color:var(--status-hijau); margin-bottom:30px;">
            <h3 style="color:var(--status-hijau); margin-bottom:10px;">✅ Peluang Terbaik Saat Ini</h3>
            <div style="display:flex; flex-wrap:wrap; gap:8px;">
                <?php $__currentLoopData = $komoditasHijau; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="badge badge-hijau" style="font-size:.9rem; padding:6px 14px;"><?php echo e($k); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Rekomendasi Alternatif -->
        <div class="section-header">
            <h2>Tanaman Alternatif Direkomendasikan</h2>
            <p>Estimasi profit lebih tinggi dibanding risiko komoditas jenuh saat ini</p>
        </div>

        <div class="grid grid-projects">
            <?php $__currentLoopData = $alternatif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card card-alternatif" style="align-items:flex-start; gap:16px; padding:24px;">
                <div class="alt-icon"><?php echo e($alt['icon']); ?></div>
                <div class="alt-body" style="flex:1">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                        <h4 style="margin:0; font-size:1.1rem;"><?php echo e($alt['nama']); ?></h4>
                        <span class="badge badge-hijau" style="font-size:.8rem;"><?php echo e($alt['keuntungan']); ?> profit</span>
                    </div>
                    <div style="display:flex; gap:16px; font-size:.82rem; color:var(--text-muted); margin-bottom:10px;">
                        <span><i class="fas fa-clock"></i> Panen ~<?php echo e($alt['masa_panen']); ?> hari</span>
                    </div>
                    <p style="font-size:.85rem; color:var(--text-muted); margin:0 0 12px;"><?php echo e($alt['tips']); ?></p>
                    <a href="<?php echo e(route('lapor-tanam')); ?>?komoditas=<?php echo e(urlencode($alt['nama'])); ?>" class="project-link" style="font-size:.85rem;">
                        Tanam Ini <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Kalkulator Simulasi -->
        <div class="section-header" style="margin-top:60px;">
            <h2>Kalkulator Simulasi Keuntungan</h2>
            <p>Estimasi kasar berdasarkan luas lahan yang akan kamu tanami</p>
        </div>

        <div class="card" style="max-width:600px; margin:0 auto;">
            <div class="form-group">
                <label style="display:block; margin-bottom:8px; color:var(--text-muted); font-size:.9rem">Pilih Komoditas Alternatif</label>
                <select id="kalkKomoditas" style="width:100%; padding:12px 16px; background:var(--bg-dark); border:1px solid var(--border); border-radius:8px; color:var(--text-main); font-family:inherit;">
                    <?php $__currentLoopData = $alternatif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($alt['masa_panen']); ?>" data-nama="<?php echo e($alt['nama']); ?>" data-pct="<?php echo e(ltrim($alt['keuntungan'], '+')); ?>"><?php echo e($alt['nama']); ?> — panen <?php echo e($alt['masa_panen']); ?> hari</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group">
                <label style="display:block; margin-bottom:8px; color:var(--text-muted); font-size:.9rem">Luas Lahan (Hektar)</label>
                <input type="number" id="kalkLuas" value="0.5" min="0.1" step="0.1"
                    style="width:100%; padding:12px 16px; background:var(--bg-dark); border:1px solid var(--border); border-radius:8px; color:var(--text-main); font-family:inherit;">
            </div>
            <div id="hasilKalkulator" style="padding:16px; background:rgba(22,163,74,.1); border:1px solid var(--primary); border-radius:8px; display:none;">
                <p style="margin:0; font-size:.9rem; color:var(--text-muted)">Estimasi hasil untuk</p>
                <h3 id="hasilJudul" style="margin:6px 0; color:var(--primary)">—</h3>
                <p id="hasilDetail" style="margin:0; font-size:.85rem; color:var(--text-muted);">—</p>
            </div>
            <button onclick="hitungKalkulator()" class="btn btn-primary btn-block" style="margin-top:14px;">Hitung Estimasi</button>
        </div>
    </div>
</section>

<script>
function hitungKalkulator() {
    const sel   = document.getElementById('kalkKomoditas');
    const luas  = parseFloat(document.getElementById('kalkLuas').value) || 0.5;
    const nama  = sel.options[sel.selectedIndex].dataset.nama;
    const hari  = parseInt(sel.value);
    const pct   = parseInt(sel.options[sel.selectedIndex].dataset.pct);

    // Asumsi kasar: 2 ton/Ha, Rp 15.000/kg
    const tonase   = luas * 2;
    const revenueBase = tonase * 1000 * 15000; // dalam Rupiah
    const revenuePlus = revenueBase * (1 + pct/100);

    const fmt = (n) => 'Rp ' + n.toLocaleString('id-ID');

    document.getElementById('hasilJudul').textContent = nama + ' — ' + luas + ' Ha';
    document.getElementById('hasilDetail').innerHTML =
        `Estimasi panen: <strong>${tonase.toFixed(1)} ton</strong> dalam <strong>${hari} hari</strong><br>
         Estimasi pendapatan: <strong>${fmt(revenuePlus)}</strong>
         <span style="color:var(--status-hijau)"> (+${pct}% vs komoditas jenuh)</span>`;
    document.getElementById('hasilKalkulator').style.display = 'block';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Ammar\Kelompok 10\resources\views/tanambijak/rekomendasi.blade.php ENDPATH**/ ?>