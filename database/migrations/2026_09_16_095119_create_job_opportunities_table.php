<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_opportunities', function (Blueprint $table) {
            $table->id('job_id');

            // Basic job information
            $table->string('title');
            $table->string('company_name');

            $table->text('description')->nullable();

            // Job location
            $table->string('country')->nullable();
            $table->string('city')->nullable();

            // Work details
            $table->string('employment_type')->nullable();
            $table->string('work_mode')->nullable();

            // Experience
            $table->unsignedInteger('minimum_experience_years')
                  ->nullable();

            // Application information
            $table->string('application_url')->nullable();
            $table->date('application_deadline')->nullable();

            // Opportunity status
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Helpful indexes
            $table->index('is_active');
            $table->index('application_deadline');
            $table->index('country');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_opportunities');
    }
};
