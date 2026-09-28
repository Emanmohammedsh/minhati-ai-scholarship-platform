<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'job_opportunity_translations',
            function (Blueprint $table) {
                $table->id('translation_id');

                $table->unsignedBigInteger('job_id');

                $table->string('locale', 10);

                $table->string('title');

                $table->string('company_name');

                $table->text('description')->nullable();

                $table->timestamps();

                $table->foreign('job_id')
                    ->references('job_id')
                    ->on('job_opportunities')
                    ->cascadeOnDelete();

                $table->unique(
                    ['job_id', 'locale'],
                    'job_translation_locale_unique'
                );

                $table->index('locale');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'job_opportunity_translations'
        );
    }
};
