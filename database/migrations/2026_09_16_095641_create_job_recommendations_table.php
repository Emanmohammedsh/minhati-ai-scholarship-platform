<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_recommendations', function (Blueprint $table) {
            $table->id('job_recommendation_id');

            // User receiving the recommendation
            $table->unsignedBigInteger('user_id');

            // Matched job opportunity
            $table->unsignedBigInteger('job_id');

            // CV used during matching, if available
            $table->unsignedBigInteger('cv_id')
                  ->nullable();

            // Final Job Match Score: 0 - 100
            $table->decimal('match_score', 5, 2)
                  ->default(0);

            // When this recommendation was generated
            $table->timestamp('generated_at')
                  ->nullable();

            $table->timestamps();

            // Relationships
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->cascadeOnDelete();

            $table->foreign('job_id')
                  ->references('job_id')
                  ->on('job_opportunities')
                  ->cascadeOnDelete();

            $table->foreign('cv_id')
                  ->references('cv_id')
                  ->on('cvs')
                  ->nullOnDelete();

            // Prevent duplicate recommendation
            // for the same user and job
            $table->unique(
                ['user_id', 'job_id'],
                'job_recommendations_user_job_unique'
            );

            $table->index('match_score');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_recommendations');
    }
};
