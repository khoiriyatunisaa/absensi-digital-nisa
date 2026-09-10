<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('qr_location_id')
                ->constrained('qr_locations')
                ->cascadeOnDelete();

            $table->foreignId('qr_token_id')
                ->constrained('qr_tokens')
                ->cascadeOnDelete();

            $table->date('attendance_date');
            $table->time('attendance_time');

            $table->string('status')->default('hadir');

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();

            $table->unique(['student_id', 'attendance_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};