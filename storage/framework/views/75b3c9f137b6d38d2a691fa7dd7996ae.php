<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($group_title ?? 'Portofolio'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>?v=<?php echo e(time()); ?>">
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <header class="navbar">
        <div class="container nav-container">
            <a href="<?php echo e(url('/')); ?>" class="logo"><?php echo e($group_name); ?><span>.</span></a>
            <nav>
                <ul class="nav-links">
                    <li><a href="<?php echo e(url('/')); ?>#home">Home</a></li>
                    <li><a href="<?php echo e(url('/')); ?>#about">About</a></li>
                    <li><a href="<?php echo e(url('/')); ?>#team">Team</a></li>
                    <li><a href="<?php echo e(url('/')); ?>#contact">Kontak</a></li>
                    <li><a href="<?php echo e(route('mata-desa')); ?>" style="color:var(--primary)"><i class="fas fa-seedling"></i> Mata Desa</a></li>
                    <li><a href="<?php echo e(route('rekomendasi')); ?>" style="color:var(--primary)">Rekomendasi</a></li>
                    <li><a href="<?php echo e(route('logistik')); ?>" style="color:var(--primary)">Logistik</a></li>
                    <li><a href="<?php echo e(route('lapor-tanam')); ?>" class="btn btn-primary" style="padding:6px 14px;font-size:.85rem">Lapor Tanam</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($group_name); ?>. All rights reserved.</p>
        </div>
    </footer>

</body>

</html><?php /**PATH D:\Ammar\Kelompok 10\resources\views/layouts/app.blade.php ENDPATH**/ ?>