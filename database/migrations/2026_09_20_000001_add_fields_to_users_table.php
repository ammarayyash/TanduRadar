<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('desa')->nullable()->after('name');
            $table->string('kecamatan')->nullable()->after('desa');
            $table->decimal('luas_lahan_total', 8, 2)->nullable()->after('kecamatan')->comment('Dalam Hektar');
            $table->enum('badge', ['Petani Cerdas', 'Penyelamat Harga', 'Anggota Baru'])->default('Anggota Baru')->after('luas_lahan_total');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['desa', 'kecamatan', 'luas_lahan_total', 'badge']);
        });
    }
};
