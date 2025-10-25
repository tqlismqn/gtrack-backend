<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('driver_id')->constrained('drivers')->cascadeOnDelete();

            // Document type (enum)
            $table->enum('type', [
                'passport',
                'visa',
                'residence',
                'licence',
                'a1_eu',
                'a1_switzerland',
                'declaration',
                'pojisteni',
                'cestovni_pojisteni',
                'drivers_licence',
                'adr',
                'chip',
                'kod_95',
                'prohlidka'
            ]);

            // Document details
            $table->string('number')->nullable();
            $table->string('country', 2)->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();

            // Status fields (NEW!)
            $table->enum('status', ['valid', 'warning', 'expiring_soon', 'expired', 'no_data'])
                  ->default('no_data');
            $table->integer('days_until_expiry')->nullable();

            // Additional metadata
            $table->json('meta')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('driver_id');
            $table->index('type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_documents');
    }
};
