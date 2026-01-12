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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('flight_number');
            $table->enum('status', ['scheduled', 'boarding', 'departed', 'arrived', 'cancelled'])->default('scheduled');

            // Time-related fields
            $table->dateTime('departure_time_scheduled');
            $table->dateTime('departure_time_estimated')->nullable();
            $table->dateTime('departure_time_actual')->nullable();
            $table->dateTime('arrival_time_scheduled');
            $table->dateTime('arrival_time_estimated')->nullable();
            $table->dateTime('arrival_time_actual')->nullable();

            // Foreign keys
            $table->foreignId('aircraft_id')->nullable()->constrained('aircraft')->nullOnDelete();
            $table->foreignId('departure_airport_id')->constrained('airports')->nullOnDelete();
            $table->foreignId('arrival_airport_id')->constrained('airports')->nullOnDelete();
            $table->foreignId('diversion_airport_id')->nullable()->constrained('airports')->nullOnDelete();
            $table->foreignId('crew_id')->nullable()->constrained('crews')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
