<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_wilayah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desa')->cascadeOnDelete();
            $table->string('koordinat')->nullable();
            $table->integer('jumlah_penduduk')->nullable();
            $table->string('kondisi_ketenagalistrikan')->nullable();
            $table->string('status_berlistrik')->nullable(); // berlistrik | belum_berlistrik | sebagian
            $table->text('potensi_energi')->nullable();
            $table->text('potensi_sumber_daya_mineral')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_wilayah');
    }
};
