<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id('profile_id');
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users', 'user_id')
                ->cascadeOnDelete();
            $table->string('academic_background')->nullable();
            $table->string('field_of_study')->nullable();
            $table->string('degree_level')->nullable();
            $table->text('interests')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
