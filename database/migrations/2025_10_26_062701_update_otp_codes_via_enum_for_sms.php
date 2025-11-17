<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // ubah enum menjadi hanya email dan sms
        Schema::table('otp_codes', function (Blueprint $table) {
            $table->enum('via', ['email', 'sms'])->change();
        });

        // ubah data lama yang masih wa/telegram agar valid (opsional, tapi aman)
        DB::table('otp_codes')
            ->whereIn('via', ['wa', 'telegram'])
            ->update(['via' => 'sms']);
    }

    public function down(): void
    {
        // kalau rollback, balikin ke enum lama
        Schema::table('otp_codes', function (Blueprint $table) {
            $table->enum('via', ['email', 'wa', 'telegram'])->change();
        });
    }
};
