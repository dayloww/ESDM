<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mineral', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi');
            $table->string('jenis_komoditas');
            $table->string('pemegang_izin');
            $table->decimal('luas', 15, 2)->nullable();       // hektar
            $table->decimal('produksi', 15, 2)->nullable();   // ton/tahun
            $table->string('dokumentasi')->nullable();
            $table->text('hasil_pemantauan')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mineral');
    }
};
