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
        Schema::create('sw_lahans', function (Blueprint $table) {
            $table->id(); // Primary Key (id_lahan)
            $table->unsignedBigInteger('id_petani'); // Relasi ke petani, wajib ada

            $table->string('nama', 100); // Nama lahan
            $table->string('lokasi', 255); // Lokasi deskriptif
            $table->decimal('luas', 8, 2); // Luas lahan dalam hektar

            // Koordinat dan URL Google Maps
            $table->decimal('latitude', 10, 8)->nullable();   // Latitude GPS
            $table->decimal('longitude', 11, 8)->nullable();  // Longitude GPS
            $table->string('maps_url', 255)->nullable();      // URL Google Maps (opsional)

            $table->timestamps();

            // Foreign key constraint dengan cascading delete
            $table->foreign('id_petani')
                ->references('id')
                ->on('sw_petanis')
                ->onDelete('cascade'); // Jika petani dihapus, lahannya juga ikut terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_lahans');
    }
};
