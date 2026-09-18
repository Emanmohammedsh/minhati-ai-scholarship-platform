<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id('job_application_id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('job_id');

            $table->enum('status', [
                'saved',
                'applied',
                'interview',
                'accepted',
                'rejected'
            ])->default('saved');

            $table->timestamp('applied_at')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('job_id')
                ->references('job_id')
                ->on('job_opportunities')
                ->cascadeOnDelete();

            // Prevent saving the same job twice for the same user.
            $table->unique(['user_id', 'job_id']);

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
