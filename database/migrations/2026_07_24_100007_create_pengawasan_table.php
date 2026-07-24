<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengawasan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('petugas');
            $table->string('objek');
            $table->string('lokasi');
            $table->text('hasil')->nullable();
            $table->text('temuan')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->string('dokumentasi')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->string('status')->default('selesai'); // selesai | dalam_proses | tertunda
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengawasan');
    }
};
