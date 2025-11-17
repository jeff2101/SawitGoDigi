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
        Schema::create('sw_supirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agen_id'); // agen yang mendaftarkan supir
            $table->string('nama', 100);
            $table->string('kontak', 100)->unique();
            $table->string('email')->unique();
            $table->string('jenis_kendaraan')->nullable();
            $table->string('password'); // Untuk login
            $table->string('foto')->nullable();

            // ✅ Tambahan kolom lokasi tracking
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('last_updated_location')->nullable();

            $table->timestamps();

            // Foreign key constraint ke tabel sw_agens
            $table->foreign('agen_id')->references('id')->on('sw_agens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_supirs');
    }
};
