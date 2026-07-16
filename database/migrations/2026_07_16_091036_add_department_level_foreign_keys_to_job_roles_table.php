<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_roles', function (Blueprint $table) {
            $table->dropColumn(['department', 'level']);
        });

        Schema::table('job_roles', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('level_id')->nullable()->constrained('levels')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('job_roles', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['level_id']);
            $table->dropColumn(['department_id', 'level_id']);
        });

        Schema::table('job_roles', function (Blueprint $table) {
            $table->string('department')->nullable();
            $table->string('level')->nullable();
        });
    }
};
