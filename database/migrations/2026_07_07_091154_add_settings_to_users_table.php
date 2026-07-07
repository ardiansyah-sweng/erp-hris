<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('language')->default('Indonesia');
            $table->string('theme')->default('Light');

            $table->boolean('email_notification')
                ->default(true);

            $table->boolean('leave_notification')
                ->default(true);

            $table->boolean('payroll_notification')
                ->default(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
