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
    Schema::create('leave_requests', function (Blueprint $table) {
        $table->id();

        $table->string('employee_id');
        $table->string('employee_name');

        $table->date('start_date');
        $table->date('end_date');

        $table->text('reason');

        $table->enum('status', [
            'Pending',
            'Approved',
            'Rejected'
        ])->default('Pending');

        $table->date('submission_date');

        $table->timestamps();
    });
}
};
