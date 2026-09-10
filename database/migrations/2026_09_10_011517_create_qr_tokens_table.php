<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_tokens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('qr_location_id')
                ->constrained('qr_locations')
                ->cascadeOnDelete();

            $table->string('token')->unique();
            $table->date('date');
            $table->dateTime('valid_from');
            $table->dateTime('valid_until');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['qr_location_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_tokens');
    }
};