<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container hero-content">
        <span class="tag-green"><i class="fas fa-plus-circle"></i> Lapor Tanam</span>
        <h1>Saya Mulai Tanam <span>Hari Ini</span></h1>
        <p>Data tanammu langsung memperbarui grafik distribusi desa secara real-time dan membantumu mendapat prioritas armada truk.</p>
    </div>
</section>

<!-- Form Section -->
<section class="section contact" style="padding-top:100px;">
    <div class="container">
        <div class="section-header">
            <h2>Form Lapor Tanam</h2>
            <p>Isi data aktivitas lahanmu sekarang</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="flash-success" style="background:rgba(239,68,68,.15); border-color:var(--status-merah); color:var(--status-merah); max-width:600px; margin:0 auto 20px;">
                <ul style="margin:0; padding-left:18px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="contact-form" action="<?php echo e(route('lapor-tanam.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:.9rem; color:var(--text-muted);">Nama Petani</label>
                <input type="text" name="nama_petani" placeholder="Masukkan nama lengkap"
                    value="<?php echo e(old('nama_petani')); ?>" required>
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:.9rem; color:var(--text-muted);">Jenis Komoditas</label>
                <select name="komoditas" required
                    style="width:100%; padding:12px 16px; background:var(--bg-card); border:1px solid var(--border); border-radius:8px; color:var(--text-main); font-family:inherit;"
                    onchange="updateEstimasiPanen(this)">
                    <option value="">-- Pilih Komoditas --</option>
                    <?php $__currentLoopData = $komoditasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k); ?>"
                            data-hari="<?php echo e($masaPanenMap[$k]); ?>"
                            <?php echo e(old('komoditas') == $k ? 'selected' : ''); ?>>
                            <?php echo e($k); ?> (~<?php echo e($masaPanenMap[$k]); ?> hari panen)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:8px; font-size:.9rem; color:var(--text-muted);">Desa</label>
                    <input type="text" name="desa" placeholder="Nama Desa"
                        value="<?php echo e(old('desa')); ?>" required>
                </div>
                <div class="form-group">
                    <label style="display:block; margin-bottom:8px; font-size:.9rem; color:var(--text-muted);">Kecamatan</label>
                    <select name="kecamatan" required
                        style="width:100%; padding:12px 16px; background:var(--bg-card); border:1px solid var(--border); border-radius:8px; color:var(--text-main); font-family:inherit;">
                        <option value="">-- Pilih Kecamatan --</option>
                        <?php $__currentLoopData = $kecamatanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kec); ?>" <?php echo e(old('kecamatan') == $kec ? 'selected' : ''); ?>><?php echo e($kec); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:8px; font-size:.9rem; color:var(--text-muted);">Luas Lahan (Hektar)</label>
                    <input type="number" name="luas_lahan" placeholder="Contoh: 0.5"
                        value="<?php echo e(old('luas_lahan')); ?>" min="0.01" step="0.01" required>
                </div>
                <div class="form-group">
                    <label style="display:block; margin-bottom:8px; font-size:.9rem; color:var(--text-muted);">Estimasi Tonase (Ton)</label>
                    <input type="number" id="estimasiTonase" name="estimasi_tonase" placeholder="Opsional"
                        value="<?php echo e(old('estimasi_tonase')); ?>" min="0" step="0.1">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:8px; font-size:.9rem; color:var(--text-muted);">Tanggal Mulai Tanam</label>
                    <input type="date" id="tanggalTanam" name="tanggal_tanam"
                        value="<?php echo e(old('tanggal_tanam', date('Y-m-d'))); ?>" required
                        onchange="updateEstimasiPanen(document.querySelector('[name=komoditas]'))">
                </div>
                <div class="form-group">
                    <label style="display:block; margin-bottom:8px; font-size:.9rem; color:var(--text-muted);">Estimasi Tanggal Panen</label>
                    <input type="date" id="estimasiPanen" name="estimasi_panen"
                        value="<?php echo e(old('estimasi_panen')); ?>" required>
                </div>
            </div>

            <!-- Info badge -->
            <div style="padding:14px 18px; background:rgba(22,163,74,.1); border:1px solid var(--primary); border-radius:8px; margin-bottom:20px; font-size:.85rem; color:var(--text-muted);">
                <i class="fas fa-info-circle" style="color:var(--primary)"></i>
                Data yang kamu kirim akan langsung memperbarui grafik distribusi komoditas di kecamatanmu dan membantu petani lain membuat keputusan tanam yang lebih cerdas.
                Petani yang rutin melapor mendapat <strong style="color:var(--primary)">prioritas VIP armada truk</strong> saat panen.
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-seedling"></i> Saya Mulai Tanam Hari Ini!
            </button>
        </form>
    </div>
</section>

<script>
const masaPanenMap = <?php echo json_encode($masaPanenMap, 15, 512) ?>;

function updateEstimasiPanen(selectEl) {
    const komoditas = selectEl.value;
    const tanggalInput = document.getElementById('tanggalTanam');
    const panenInput   = document.getElementById('estimasiPanen');

    if (!komoditas || !tanggalInput.value) return;

    const hari = masaPanenMap[komoditas];
    if (!hari) return;

    const tanggal = new Date(tanggalInput.value);
    tanggal.setDate(tanggal.getDate() + hari);

    const yyyy = tanggal.getFullYear();
    const mm   = String(tanggal.getMonth() + 1).padStart(2, '0');
    const dd   = String(tanggal.getDate()).padStart(2, '0');
    panenInput.value = `${yyyy}-${mm}-${dd}`;
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Ammar\Kelompok 10\resources\views/tanambijak/lapor-tanam.blade.php ENDPATH**/ ?>