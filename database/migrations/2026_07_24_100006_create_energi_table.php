<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('energi', function (Blueprint $table) {
            $table->id();
            $table->string('desa'); // plain text per DATABASE.md (bukan FK)
            $table->string('sumber_energi');
            $table->string('kapasitas')->nullable();
            $table->string('jaringan')->nullable();
            $table->text('potensi_ebt')->nullable();
            $table->text('kondisi_infrastruktur')->nullable();
            $table->text('permasalahan')->nullable();
            $table->string('dokumentasi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('energi');
    }
};
