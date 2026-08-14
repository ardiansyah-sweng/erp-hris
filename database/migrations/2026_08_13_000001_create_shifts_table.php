<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Pagi, Siang, Malam, Normal
            $table->time('start_time');        // Jam masuk
            $table->time('end_time');          // Jam keluar
            $table->decimal('total_hours', 4, 1)->default(8); // Total jam kerja
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
