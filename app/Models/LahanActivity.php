<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LahanActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_petani',
        'komoditas',
        'desa',
        'kecamatan',
        'luas_lahan',
        'tanggal_tanam',
        'estimasi_panen',
        'estimasi_tonase',
        'status',
    ];

    protected $casts = [
        'tanggal_tanam'   => 'date',
        'estimasi_panen'  => 'date',
        'luas_lahan'      => 'decimal:2',
        'estimasi_tonase' => 'decimal:2',
    ];

    /**
     * Relasi ke User (petani pemilik lahan).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: filter berdasarkan kecamatan.
     */
    public function scopeKecamatan($query, $kecamatan)
    {
        return $query->where('kecamatan', $kecamatan)->where('status', 'aktif');
    }

    /**
     * Hitung estimasi hari menuju panen dari hari ini.
     */
    public function getHariMenujuPanenAttribute(): int
    {
        return max(0, now()->diffInDays($this->estimasi_panen, false));
    }
}
