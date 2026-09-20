<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lahan_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama_petani');
            $table->string('komoditas');
            $table->string('desa');
            $table->string('kecamatan');
            $table->decimal('luas_lahan', 8, 2)->comment('Dalam Hektar');
            $table->date('tanggal_tanam');
            $table->date('estimasi_panen');
            $table->decimal('estimasi_tonase', 8, 2)->nullable()->comment('Dalam Ton');
            $table->enum('status', ['aktif', 'panen', 'gagal'])->default('aktif');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lahan_activities');
    }
};
