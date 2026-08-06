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
        Schema::create('recruitments', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email');
            $table->string('phone_number');

            $table->foreignId('role_id')
                ->constrained('job_roles')
                ->cascadeOnDelete();

            $table->date('apply_date');
            $table->string('cv')->nullable();

            $table->enum('status', [
                'Screening',
                'Interview',
                'Accepted',
                'Rejected',
            ])->default('Screening');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitments');
    }
};
