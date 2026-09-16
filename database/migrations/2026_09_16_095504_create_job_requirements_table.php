<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_requirements', function (Blueprint $table) {
            $table->id('requirement_id');

            // The job this requirement belongs to
            $table->unsignedBigInteger('job_id');

            // Examples:
            // skill, education, experience,
            // qualification, language
            $table->string('requirement_type');

            // Examples:
            // Python, Bachelor, 2 years, English
            $table->string('required_value');

            // Mandatory requirements can later be treated
            // differently by the matching engine.
            $table->boolean('is_mandatory')
                  ->default(false);

            // Contribution of this requirement
            // to the final Job Match Score.
            $table->decimal('weight', 5, 2)
                  ->default(0);

            $table->timestamps();

            $table->foreign('job_id')
                  ->references('job_id')
                  ->on('job_opportunities')
                  ->cascadeOnDelete();

            $table->index('job_id');
            $table->index('requirement_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_requirements');
    }
};
