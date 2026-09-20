<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container hero-content">
        <span class="tag">Portofolio Resmi</span>
        <h1><?php echo e($hero_title); ?> oleh <span><?php echo e($group_name); ?></span></h1>
        <p><?php echo e($hero_subtitle); ?></p>
        <div class="hero-buttons">
            <a href="#projects" class="btn btn-primary">Lihat Proyek</a>
            <a href="#team" class="btn btn-secondary">Tim Kami</a>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="section about">
    <div class="container">
        <div class="section-header">
            <h2>Tentang Kelompok</h2>
            <p>Kami berkolaborasi untuk menciptakan karya web yang fungsional, responsif, dan berdampak positif.</p>
        </div>
    </div>
</section>

<!-- TanamBijak System Section -->
<section id="tanambijak" class="section" style="padding-top:20px;">
    <div class="container">
        <div class="section-header">
            <h2><span style="color:var(--primary)">🌱 TanamBijak</span> — Proyek Unggulan</h2>
            <p>Platform manajemen rotasi tanam berbasis komunitas untuk mencegah oversupply komoditas pertanian</p>
        </div>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(260px,1fr)); gap:20px; margin-bottom:30px;">
            <a href="<?php echo e(route('mata-desa')); ?>" class="card" style="text-decoration:none; display:block; text-align:center;">
                <div style="font-size:2.5rem; margin-bottom:10px;">📊</div>
                <h3 style="color:var(--primary)">Mata Desa</h3>
                <p class="bio">Visualisasi distribusi komoditas real-time per kecamatan dengan indikator Merah/Kuning/Hijau.</p>
                <span class="project-link">Buka Modul <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="<?php echo e(route('rekomendasi')); ?>" class="card" style="text-decoration:none; display:block; text-align:center;">
                <div style="font-size:2.5rem; margin-bottom:10px;">💡</div>
                <h3 style="color:var(--primary)">Rekomendasi Cerdas</h3>
                <p class="bio">Saran komoditas alternatif saat lahan jenuh, lengkap dengan kalkulator estimasi keuntungan.</p>
                <span class="project-link">Buka Modul <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="<?php echo e(route('logistik')); ?>" class="card" style="text-decoration:none; display:block; text-align:center;">
                <div style="font-size:2.5rem; margin-bottom:10px;">🚛</div>
                <h3 style="color:var(--primary)">Eco-Logistik</h3>
                <p class="bio">Jadwal panen desa & koordinasi armada truk. Tracker sayur terselamatkan dari food waste.</p>
                <span class="project-link">Buka Modul <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="<?php echo e(route('lapor-tanam')); ?>" class="card" style="text-decoration:none; display:block; text-align:center; border-color:var(--primary);">
                <div style="font-size:2.5rem; margin-bottom:10px;">✍️</div>
                <h3 style="color:var(--primary)">Lapor Tanam</h3>
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
            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card card-member">
                    <img src="<?php echo e($member['avatar']); ?>" alt="<?php echo e($member['name']); ?>" class="avatar">
                    <h3><?php echo e($member['name']); ?></h3>
                    <span class="role"><?php echo e($member['role']); ?></span>
                    <p class="bio"><?php echo e($member['bio']); ?></p>
                    
                    <div class="skills">
                        <?php $__currentLoopData = $member['skills']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge"><?php echo e($skill); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card card-project">
                    <div class="project-img-wrapper">
                        <img src="<?php echo e($project['image']); ?>" alt="<?php echo e($project['title']); ?>">
                    </div>
                    <div class="project-body">
                        <span class="category"><?php echo e($project['category']); ?></span>
                        <h3><?php echo e($project['title']); ?></h3>
                        <p><?php echo e($project['description']); ?></p>
                        <a href="<?php echo e($project['link']); ?>" class="project-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <?php echo csrf_field(); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Ammar\Kelompok 10\resources\views/portfolio.blade.php ENDPATH**/ ?>