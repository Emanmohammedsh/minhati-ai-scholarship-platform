<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_requirement_matches', function (Blueprint $table) {
            $table->id('match_id');

            // Recommendation this result belongs to
            $table->unsignedBigInteger('job_recommendation_id');

            // Requirement that was evaluated
            $table->unsignedBigInteger('requirement_id');

            // Did the user's profile/CV satisfy this requirement?
            $table->boolean('is_satisfied')
                  ->default(false);

            // Points contributed to the final Job Match Score
            $table->decimal('contribution_points', 5, 2)
                  ->default(0);

            $table->timestamps();

            $table->foreign('job_recommendation_id')
                  ->references('job_recommendation_id')
                  ->on('job_recommendations')
                  ->cascadeOnDelete();

            $table->foreign('requirement_id')
                  ->references('requirement_id')
                  ->on('job_requirements')
                  ->cascadeOnDelete();

            // One evaluation per requirement
            // inside each recommendation
            $table->unique(
                ['job_recommendation_id', 'requirement_id'],
                'job_requirement_matches_unique'
            );

            $table->index('is_satisfied');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_requirement_matches');
    }
};
