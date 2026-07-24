<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('potensi_pad', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kegiatan');
            $table->string('komoditas')->nullable();
            $table->decimal('volume', 15, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->string('periode')->nullable();
            $table->decimal('nilai_produksi', 15, 2)->nullable();
            $table->string('pelaku_usaha')->nullable();
            $table->string('lokasi');
            $table->decimal('estimasi_penerimaan', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('potensi_pad');
    }
};
