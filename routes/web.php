<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\TanamBijakController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ─── Halaman Portofolio (tetap) ───────────────────────────────────────────
Route::get('/', [PortfolioController::class, 'index']);

// ─── TanamBijak: Modul A — Mata Desa ──────────────────────────────────────
Route::get('/mata-desa', [TanamBijakController::class, 'mataDesa'])->name('mata-desa');

// ─── TanamBijak: Modul B — Rekomendasi Cerdas ─────────────────────────────
Route::get('/rekomendasi', [TanamBijakController::class, 'rekomendasi'])->name('rekomendasi');

// ─── TanamBijak: Modul C — Eco-Logistik ───────────────────────────────────
Route::get('/logistik', [TanamBijakController::class, 'logistik'])->name('logistik');

// ─── TanamBijak: Lapor Tanam ──────────────────────────────────────────────
Route::get('/lapor-tanam',  [TanamBijakController::class, 'laporTanam'])->name('lapor-tanam');
Route::post('/lapor-tanam', [TanamBijakController::class, 'storeLaporTanam'])->name('lapor-tanam.store');
