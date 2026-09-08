<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_applications', function (Blueprint $table) {
            $table->id('saved_application_id');

            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnDelete();

            $table->foreignId('scholarship_id')
                ->constrained('scholarships', 'scholarship_id')
                ->cascadeOnDelete();

            $table->enum('status', [
                'saved',
                'submitted',
                'under_review',
            ])->default('saved');

            $table->timestamp('saved_at')->nullable();
            $table->timestamp('status_updated_at')->nullable();

            $table->unique(['user_id', 'scholarship_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_applications');
    }
};
