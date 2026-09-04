<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendation_criteria_matches', function (Blueprint $table) {
            $table->id('match_id');
            $table->foreignId('recommendation_id')->constrained('recommendations', 'recommendation_id')->cascadeOnDelete();
            $table->foreignId('criterion_id')->constrained('scholarship_criteria', 'criterion_id')->cascadeOnDelete();
            $table->boolean('is_satisfied')->default(false);
            $table->decimal('contribution_points', 5, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation_criteria_matches');
    }
};
