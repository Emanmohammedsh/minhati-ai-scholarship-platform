<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cv_id');
            $table->unsignedBigInteger('scholarship_id');
            $table->json('content');
            $table->json('applied_sections');
            $table->timestamps();

            $table->unique(['cv_id', 'scholarship_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_versions');
    }
};