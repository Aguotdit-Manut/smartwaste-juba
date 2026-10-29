<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pickup_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resident_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('address_id')
                ->constrained('addresses')
                ->restrictOnDelete();

            $table->foreignId('collector_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('request_type')->default('immediate');
            $table->dateTime('scheduled_at')->nullable();

            $table->string('status')->default('pending');

            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('payment_status')->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_requests');
    }
};