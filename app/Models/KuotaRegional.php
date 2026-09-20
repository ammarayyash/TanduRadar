<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaRegional extends Model
{
    use HasFactory;

    protected $fillable = [
        'kecamatan',
        'komoditas',
        'persen_max',
        'deskripsi',
    ];

    protected $casts = [
        'persen_max' => 'decimal:2',
    ];

    /**
     * Ambil kuota aman untuk komoditas tertentu di suatu kecamatan.
     */
    public static function getKuota(string $kecamatan, string $komoditas): float
    {
        $record = static::where('kecamatan', $kecamatan)
            ->where('komoditas', $komoditas)
            ->first();

        return $record ? (float) $record->persen_max : 40.0; // default 40%
    }
}
