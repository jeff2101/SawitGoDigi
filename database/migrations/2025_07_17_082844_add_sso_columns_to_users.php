<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('provider')->nullable()->after('email');
            $table->string('provider_id')->nullable()->after('provider');
            $table->enum('role', ['admin', 'agen', 'supir', 'petani'])->default('petani')->after('provider_id');
        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn(['provider', 'provider_id', 'role']);
        });
    }

};
