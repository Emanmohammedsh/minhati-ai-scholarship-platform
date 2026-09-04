<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarship_criteria', function (Blueprint $table) {
            $table->id('criterion_id');
            $table->foreignId('scholarship_id')->constrained('scholarships', 'scholarship_id')->cascadeOnDelete();
            $table->string('criterion');
            $table->unsignedTinyInteger('weight')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarship_criteria');
    }
};
