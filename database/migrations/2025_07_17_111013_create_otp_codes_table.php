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
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();

            $table->string('user_type'); // admin, agen, petani, supir
            $table->unsignedBigInteger('user_id');
            $table->string('kode_otp', 10);
            $table->enum('via', ['email', 'sms']);

            $table->timestamp('expired_at'); // Tidak pakai ON UPDATE
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            $table->index(['user_type', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_codes');
    }
};
