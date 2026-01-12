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
        Schema::create('flight_crew_transfers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        
            $table->foreignId('crew_id')->constrained('crews')->cascadeOnDelete();
            $table->foreignId('flight_id')->constrained('flights')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_crew_transfers');
    }
};
