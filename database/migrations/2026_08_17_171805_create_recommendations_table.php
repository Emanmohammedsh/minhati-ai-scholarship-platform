<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id('recommendation_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->cascadeOnDelete();
            $table->foreignId('scholarship_id')->constrained('scholarships', 'scholarship_id')->cascadeOnDelete();
            $table->foreignId('cv_id')->nullable()->constrained('cvs', 'cv_id')->nullOnDelete();
            $table->decimal('match_score', 5, 2)->default(0);
            $table->timestamp('generated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
