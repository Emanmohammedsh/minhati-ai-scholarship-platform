<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cvs', function (Blueprint $table) {
            $table->id('cv_id');

            $table->unsignedBigInteger('user_id');

            $table->string('file_path');
            $table->string('original_filename');
            $table->unsignedBigInteger('file_size_bytes');
            $table->string('mime_type');

            $table->boolean('is_active')->default(true);

            $table->enum('extraction_status', [
                'pending',
                'processing',
                'completed',
                'failed',
            ])->default('pending');

            $table->json('extracted_skills')->nullable();
            $table->json('extracted_education')->nullable();
            $table->json('extracted_qualifications')->nullable();

            $table->timestamp('extraction_requested_at')->nullable();
            $table->timestamp('extraction_completed_at')->nullable();

            $table->boolean('reviewed_by_student')->default(false);
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->index(['user_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};
