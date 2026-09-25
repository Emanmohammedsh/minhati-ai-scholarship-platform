<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saved_applications', function (Blueprint $table) {
            $table->unique(['user_id', 'scholarship_id'], 'saved_app_unique');
        });
    }

    public function down(): void
    {
        Schema::table('saved_applications', function (Blueprint $table) {
            $table->dropUnique('saved_app_unique');
        });
    }
}; 