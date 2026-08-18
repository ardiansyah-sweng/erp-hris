<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('date');
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->onDelete('set null');
            $table->time('scheduled_out');     // Jam keluar sesuai shift
            $table->time('actual_out');        // Jam keluar aktual
            $table->decimal('overtime_hours', 4, 1);  // Total jam lembur
            $table->decimal('hourly_rate', 15, 2)->default(0); // Upah per jam
            $table->decimal('overtime_pay', 15, 2)->default(0); // Total upah lembur
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};
