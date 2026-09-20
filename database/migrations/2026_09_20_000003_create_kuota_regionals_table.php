<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuota_regionals', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan');
            $table->string('komoditas');
            $table->decimal('persen_max', 5, 2)->comment('Persentase maksimal lahan aman');
            $table->string('deskripsi')->nullable();
            $table->timestamps();

            $table->unique(['kecamatan', 'komoditas']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuota_regionals');
    }
};
