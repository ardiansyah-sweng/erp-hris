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
            $table->string('name')->after('role')->nullable();
            $table->string('department')->after('name')->nullable();
            $table->string('level')->after('department')->nullable();
            $table->string('status')->after('level')->default('Active');
        });

        // Migrate existing JSON data from 'role' column to new columns
        $jobroles = \DB::table('job_roles')->get();
        foreach ($jobroles as $jobrole) {
            $decoded = json_decode($jobrole->role, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                \DB::table('job_roles')->where('id', $jobrole->id)->update([
                    'name' => $decoded['role'] ?? $jobrole->role,
                    'department' => $decoded['department'] ?? '-',
                    'level' => $decoded['level'] ?? '-',
                    'status' => $decoded['status'] ?? 'Active',
                ]);
            } else {
                \DB::table('job_roles')->where('id', $jobrole->id)->update([
                    'name' => $jobrole->role,
                    'department' => '-',
                    'level' => '-',
                    'status' => 'Active',
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_roles', function (Blueprint $table) {
            $table->dropColumn(['name', 'department', 'level', 'status']);
        });
    }
};
