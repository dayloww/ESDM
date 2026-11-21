<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('energi', function (Blueprint $table) {
            // Field umum
            $table->string('jenis_usaha')->nullable()->after('desa'); // IUPTLS | UPTL | Lainnya

            // ── Field IUPTLS ──────────────────────────────────────────────
            $table->string('nomor_izin')->nullable()->after('jenis_usaha');
            $table->string('nama_pemegang_izin')->nullable()->after('nomor_izin');
            $table->string('nib')->nullable()->after('nama_pemegang_izin');
            $table->string('badan_usaha')->nullable()->after('nib');
            $table->string('jenis_pembangkit')->nullable()->after('badan_usaha');
            $table->string('jumlah_unit')->nullable()->after('jenis_pembangkit');
            $table->string('latitude')->nullable()->after('jumlah_unit');
            $table->string('longitude')->nullable()->after('latitude');
            $table->date('tanggal_terbit')->nullable()->after('longitude');
            $table->date('masa_berlaku')->nullable()->after('tanggal_terbit');
            $table->string('status')->nullable()->after('masa_berlaku'); // aktif | nonaktif | habis
            $table->text('keterangan')->nullable()->after('status');

            // ── Field UPTL ────────────────────────────────────────────────
            $table->string('nama_badan_usaha')->nullable()->after('keterangan');
            $table->string('penanggung_jawab')->nullable()->after('nama_badan_usaha');
            $table->string('jenis_usaha_penunjang')->nullable()->after('penanggung_jawab');
            $table->string('bidang_kegiatan')->nullable()->after('jenis_usaha_penunjang');
            $table->string('klasifikasi_usaha')->nullable()->after('bidang_kegiatan');
        });
    }

    public function down(): void
    {
        Schema::table('energi', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_usaha',
                // IUPTLS
                'nomor_izin',
                'nama_pemegang_izin',
                'nib',
                'badan_usaha',
                'jenis_pembangkit',
                'jumlah_unit',
                'latitude',
                'longitude',
                'tanggal_terbit',
                'masa_berlaku',
                'status',
                'keterangan',
                // UPTL
                'nama_badan_usaha',
                'penanggung_jawab',
                'jenis_usaha_penunjang',
                'bidang_kegiatan',
                'klasifikasi_usaha',
            ]);
        });
    }
};
