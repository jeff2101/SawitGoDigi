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
        Schema::create('sw_agens', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('id_mutu')->nullable();
            $table->unsignedBigInteger('id_supir')->nullable();
            $table->unsignedBigInteger('id_usaha')->nullable(); // Tambah kolom id_usaha sebagai foreign key
            $table->string('nama', 255);
            $table->string('alamat', 255)->nullable(); // Mengubah alamat menjadi nullable
            $table->string('kontak', 12)->unique(); // kontak sekarang unik
            $table->string('email')->unique(); // email unik
            $table->string('password'); // Untuk login
            $table->string('foto')->nullable();
            $table->rememberToken(); // Untuk fitur remember me
            $table->timestamps(); // created_at & updated_at

            $table->foreign('id_usaha')->references('id')->on('usahas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_agens');
    }
};
