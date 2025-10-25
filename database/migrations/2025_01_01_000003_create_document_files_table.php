<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('document_id')
                  ->constrained('driver_documents')
                  ->onDelete('cascade');

            $table->string('file_name');
            $table->string('mime_type', 100);
            $table->integer('size_bytes')->unsigned();
            $table->string('storage_path')->comment('Path in storage (S3/FTP/local)');

            $table->integer('version')->unsigned()->default(1);
            $table->boolean('is_current')->default(true);

            $table->foreignUuid('uploaded_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamp('uploaded_at');

            // Indexes
            $table->index(['document_id', 'is_current']);
            $table->index('uploaded_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_files');
    }
};
