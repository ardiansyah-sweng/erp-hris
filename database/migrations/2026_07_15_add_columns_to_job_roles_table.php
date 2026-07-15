<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_roles', function (Blueprint $table) {
            $table->string('department')->nullable()->after('role');
            $table->string('level')->nullable()->after('department');
            $table->string('status')->default('Active')->after('level');
        });
    }

    public function down(): void
    {
        Schema::table('job_roles', function (Blueprint $table) {
            $table->dropColumn(['department', 'level', 'status']);
        });
    }
};
