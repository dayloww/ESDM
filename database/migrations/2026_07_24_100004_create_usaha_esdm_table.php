<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usaha_esdm', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelaku_usaha');
            $table->string('nomor_identitas')->nullable();
            $table->string('nomor_perizinan')->nullable();
            $table->string('jenis_usaha');
            $table->string('komoditas')->nullable();
            $table->string('lokasi');
            $table->string('koordinat')->nullable();
            $table->string('status')->default('aktif'); // aktif | nonaktif | izin_habis
            $table->decimal('produksi', 15, 2)->nullable();
            $table->decimal('penjualan', 15, 2)->nullable();
            $table->string('dokumen')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usaha_esdm');
    }
};
