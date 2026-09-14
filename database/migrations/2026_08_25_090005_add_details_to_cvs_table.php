<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
            $table->string('file_path');
            $table->string('original_filename');
            $table->unsignedBigInteger('file_size_bytes');
            $table->string('mime_type');
            $table->boolean('is_active')->default(false);

            // FR-07 / FR-08: AI extraction lifecycle
            // pending -> processing -> completed / failed -> confirmed
            $table->string('extraction_status')->default('pending');
            $table->json('extracted_skills')->nullable();
            $table->json('extracted_education')->nullable();
            $table->json('extracted_qualifications')->nullable();
            $table->text('extraction_error')->nullable();
            $table->timestamp('confirmed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'file_path',
                'original_filename',
                'file_size_bytes',
                'mime_type',
                'is_active',
                'extraction_status',
                'extracted_skills',
                'extracted_education',
                'extracted_qualifications',
                'extraction_error',
                'confirmed_at',
            ]);
        });
    }
};