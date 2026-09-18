<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            if (! Schema::hasColumn('cvs', 'user_id')) {
                $table->foreignId('user_id')->after('cv_id')->constrained()->cascadeOnDelete();
            }
            if (! Schema::hasColumn('cvs', 'file_path')) {
                $table->string('file_path');
            }
            if (! Schema::hasColumn('cvs', 'original_filename')) {
                $table->string('original_filename');
            }
            if (! Schema::hasColumn('cvs', 'file_size_bytes')) {
                $table->unsignedBigInteger('file_size_bytes');
            }
            if (! Schema::hasColumn('cvs', 'mime_type')) {
                $table->string('mime_type');
            }
            if (! Schema::hasColumn('cvs', 'is_active')) {
                $table->boolean('is_active')->default(false);
            }

            // FR-07 / FR-08: AI extraction lifecycle
            // pending -> processing -> completed / failed -> confirmed
            if (! Schema::hasColumn('cvs', 'extraction_status')) {
                $table->string('extraction_status')->default('pending');
            }
            if (! Schema::hasColumn('cvs', 'extracted_skills')) {
                $table->json('extracted_skills')->nullable();
            }
            if (! Schema::hasColumn('cvs', 'extracted_education')) {
                $table->json('extracted_education')->nullable();
            }
            if (! Schema::hasColumn('cvs', 'extracted_qualifications')) {
                $table->json('extracted_qualifications')->nullable();
            }
            if (! Schema::hasColumn('cvs', 'extraction_error')) {
                $table->text('extraction_error')->nullable();
            }
            if (! Schema::hasColumn('cvs', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            if (Schema::hasColumn('cvs', 'user_id')) {
                $table->dropForeign(['user_id']);
            }
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