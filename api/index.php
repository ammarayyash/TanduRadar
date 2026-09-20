<?php

/**
 * Vercel PHP Entrypoint for Laravel 10
 */

$tmpStorage = '/tmp/storage';
$directories = [
    "$tmpStorage/app/public",
    "$tmpStorage/framework/cache/data",
    "$tmpStorage/framework/sessions",
    "$tmpStorage/framework/testing",
    "$tmpStorage/framework/views",
    "$tmpStorage/logs"
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

require __DIR__ . '/../public/index.php';
