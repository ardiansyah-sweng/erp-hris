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
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->string('employee_code', 10)->nullable()->unique()->after('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone_number');
        $table->string('place_of_birth');
        $table->date('date_of_birth');
        $table->string('address');
        $table->string('id_number');
        $table->integer('age')->default(0);
        $table->unsignedBigInteger('role_id');
        $table->string('status')->default('active');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};