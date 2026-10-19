<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('student_name');
            $table->date('schedule_date');
            $table->time('schedule_time');
            $table->string('material_file')->nullable();
            $table->enum('attendance', ['belum_absen', 'hadir', 'absen'])->default('belum_absen');
            $table->timestamps();

            $table->index(['user_id', 'schedule_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
