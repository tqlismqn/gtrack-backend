<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('internal_number')->unique()->comment('Auto-increment internal ID');

            // Personal data
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('birth_date');
            $table->string('citizenship', 2)->comment('ISO 3166-1 country code');
            $table->string('rodne_cislo', 20)->nullable()->comment('Czech birth number');

            // Contact information
            $table->string('email')->unique();
            $table->string('phone', 20);
            $table->text('reg_address')->comment('Registration address');
            $table->text('res_address')->nullable()->comment('Residence address');

            // Employment
            $table->enum('status', ['active', 'on_leave', 'inactive', 'terminated'])
                  ->default('active');
            $table->date('hire_date');
            $table->date('fire_date')->nullable();
            $table->date('contract_from')->nullable();
            $table->date('contract_to')->nullable();
            $table->boolean('contract_indefinite')->default(false);
            $table->enum('work_location', ['praha', 'kladno'])->default('praha');

            // Banking information
            $table->string('bank_country', 2)->nullable()->comment('ISO country code');
            $table->string('bank_account')->nullable();
            $table->string('iban')->nullable();
            $table->string('swift', 11)->nullable();

            // Additional flags (JSONB)
            $table->jsonb('flags')->nullable()->comment('Additional boolean flags');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('email');
            $table->index(['first_name', 'last_name']);
        });

        // Create sequence for internal_number
        DB::statement('CREATE SEQUENCE IF NOT EXISTS drivers_internal_number_seq START 1');
    }

    public function down(): void
    {
        DB::statement('DROP SEQUENCE IF EXISTS drivers_internal_number_seq');
        Schema::dropIfExists('drivers');
    }
};
