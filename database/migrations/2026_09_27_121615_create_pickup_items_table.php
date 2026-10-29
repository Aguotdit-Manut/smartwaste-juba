<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pickup_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pickup_request_id')
                ->constrained('pickup_requests')
                ->cascadeOnDelete();

            $table->foreignId('waste_category_id')
                ->constrained('waste_categories')
                ->restrictOnDelete();

            $table->decimal('quantity', 10, 2);
            $table->string('unit')->default('kg');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_items');
    }
};