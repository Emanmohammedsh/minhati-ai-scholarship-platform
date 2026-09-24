<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('skill_tag')->index();
            $table->string('title');
            $table->string('url');
            $table->string('provider')->nullable();
            $table->unsignedSmallInteger('hours')->nullable();
            $table->boolean('is_free')->default(true);
            $table->string('language', 5)->default('en');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};