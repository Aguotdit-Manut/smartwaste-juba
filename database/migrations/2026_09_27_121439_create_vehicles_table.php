<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('collector_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('vehicle_type')->default('Tuk Tuk');
            $table->string('registration_number')->unique();
            $table->decimal('capacity_kg', 8, 2)->nullable();

            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};