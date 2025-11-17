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
        Schema::create('sw_petanis', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('nama', 100);
            $table->string('alamat', 100)->nullable(); // Mengubah alamat menjadi nullable
            $table->string('kontak', 100)->unique(); // Menjadikan kontak unik
            $table->string('email')->unique(); // email unik
            $table->string('password'); // Untuk login
            $table->unsignedBigInteger('id_lahan')->nullable(); // Indeks lahan
            $table->string('foto')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_petanis');
    }
};
