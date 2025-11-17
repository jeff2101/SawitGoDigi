<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sw_pemesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_lahan')->nullable(); // Relasi ke sw_lahans
            $table->unsignedBigInteger('id_petani');            // Relasi ke sw_petanis
            $table->unsignedBigInteger('id_supir')->nullable(); // 👈 Tambahan kolom relasi ke sw_supirs

            $table->string('lokasi_jemput');                    // Lokasi penjemputan wajib
            $table->text('google_maps_url')->nullable();        // Optional Maps URL
            $table->decimal('latitude', 10, 7)->nullable();     // Koordinat lokasi
            $table->decimal('longitude', 10, 7)->nullable();

            $table->decimal('bobot_estimasi', 8, 2);            // Estimasi bobot buah (kg)
            $table->enum('jenis_pemesanan', ['buah_petani', 'buah_pt']); // Jenis
            $table->date('tanggal_pemesanan');                  // Tanggal

            $table->enum('status_pemesanan', [
                'pending',
                'dibatalkan',
                'proses',
                'dijemput',
                'proses_transaksi',
                'selesai'
            ])->default('pending');                             // Status default

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_lahan')->references('id')->on('sw_lahans')->onDelete('set null');
            $table->foreign('id_petani')->references('id')->on('sw_petanis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_pemesanans');
    }
};
