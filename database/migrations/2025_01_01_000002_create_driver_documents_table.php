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
            $table->foreignUuid('driver_id')
                  ->constrained('drivers')
                  ->onDelete('cascade');

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
            ])->comment('Document type');

            $table->string('number', 50)->nullable()->comment('Document number');
            $table->string('country', 2)->nullable()->comment('ISO country code');
            $table->date('from')->nullable()->comment('Valid from date');
            $table->date('to')->nullable()->comment('Valid to / expiry date');

            $table->jsonb('meta')->nullable()->comment('Additional metadata');

            $table->timestamps();

            // Indexes
            $table->index(['driver_id', 'type']);
            $table->index('to')->comment('For expiry date queries');

            // Unique constraint: one document of each type per driver
            $table->unique(['driver_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_documents');
    }
};
