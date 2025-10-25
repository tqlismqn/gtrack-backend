<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('driver_id')
                  ->constrained('drivers')
                  ->onDelete('cascade');

            $table->foreignUuid('author_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->text('text');

            $table->foreignUuid('attachment_file_id')
                  ->nullable()
                  ->constrained('document_files')
                  ->nullOnDelete();

            $table->timestamps();

            // Indexes
            $table->index('driver_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_comments');
    }
};
