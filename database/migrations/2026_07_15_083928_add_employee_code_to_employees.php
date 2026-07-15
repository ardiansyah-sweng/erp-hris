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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('employee_code', 10)->nullable()->after('id');
        });

        DB::statement("UPDATE employees SET employee_code = CONCAT('EMP', LPAD(id, 3, '0')) WHERE employee_code IS NULL");

        Schema::table('employees', function (Blueprint $table) {
            $table->unique('employee_code');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('employee_code');
        });
    }
};
