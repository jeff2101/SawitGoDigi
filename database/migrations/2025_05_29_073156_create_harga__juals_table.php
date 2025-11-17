<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sw_harga_juals', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('agen_id'); // Agen yang menetapkan harga
            $table->decimal('harga_tbs', 10, 2); // Harga TBS ke petani (wajib)
            $table->decimal('harga_brondol', 10, 2)->nullable(); // Harga brondolan (boleh kosong jika tidak digunakan)
            $table->timestamp('waktu_ditetapkan')->default(DB::raw('CURRENT_TIMESTAMP')); // Waktu harga berlaku
            $table->text('catatan')->nullable(); // Catatan tambahan / alasan perubahan harga
            $table->timestamps(); // created_at & updated_at

            // Relasi ke tabel agen
            $table->foreign('agen_id')->references('id')->on('sw_agens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_harga_juals');
    }
};
