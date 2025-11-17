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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('agen_id')->constrained('sw_agens')->onDelete('cascade');
            $table->foreignId('petani_id')->nullable()->constrained('sw_petanis')->onDelete('set null');
            $table->foreignId('pemesanan_id')->nullable()->constrained('sw_pemesanans')->onDelete('set null');

            // Jenis
            $table->enum('jenis_transaksi', ['langsung', 'pesanan'])->default('langsung');

            // Berat & Potongan
            $table->decimal('berat_tbs', 8, 2)->default(0);
            $table->decimal('berat_brondol', 8, 2)->default(0);
            $table->decimal('potongan_persen', 5, 2)->nullable();
            $table->decimal('potongan_alas_timbang', 8, 2)->nullable();

            // Mutu (umum dan per buah)
            $table->enum('mutu_buah', ['mentah', 'matang', 'busuk']); // bisa tetap dipakai sebagai status utama
            $table->enum('mutu_buah_a', ['mentah', 'matang', 'busuk'])->nullable();
            $table->enum('mutu_buah_b', ['mentah', 'matang', 'busuk'])->nullable();

            // Harga & Berat per jenis
            $table->decimal('berat_tbs_a', 8, 2)->nullable();
            $table->decimal('berat_tbs_b', 8, 2)->nullable();
            $table->decimal('harga_tbs_a', 10, 2)->nullable();
            $table->decimal('harga_tbs_b', 10, 2)->nullable();
            $table->decimal('harga_brondol', 10, 2)->nullable();

            // Harga total
            $table->decimal('total_harga_awal', 15, 2); // dari semua jenis sebelum dikurangi dll
            $table->decimal('total_bersih', 15, 2);     // hasil akhir

            // Lain-lain
            $table->enum('metode_pembayaran', ['tunai', 'transfer'])->default('tunai');
            $table->date('tanggal')->nullable();
            $table->string('bukti_transaksi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
