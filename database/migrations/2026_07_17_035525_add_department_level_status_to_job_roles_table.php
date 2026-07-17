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
        Schema::table('job_roles', function (Blueprint $table) {
            if (!Schema::hasColumn('job_roles', 'department')) {
                $table->string('department')->nullable()->after('role');
            }
            if (!Schema::hasColumn('job_roles', 'level')) {
                $table->string('level')->nullable()->after('department');
            }
            if (!Schema::hasColumn('job_roles', 'status')) {
                $table->string('status')->default('Active')->after('level');
            }
        });
    }

    public function down(): void
    {
        Schema::table('job_roles', function (Blueprint $table) {
            $columns = ['department', 'level', 'status'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('job_roles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
