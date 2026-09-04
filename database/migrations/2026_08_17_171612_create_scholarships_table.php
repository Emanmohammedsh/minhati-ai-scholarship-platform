<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id('scholarship_id');
            $table->foreignId('created_by_admin_id')->nullable()->constrained('users', 'user_id')->nullOnDelete();
            $table->string('title');
            $table->string('provider_name')->nullable();
            $table->text('description')->nullable();
            $table->string('country')->nullable();
            $table->string('field_of_study')->nullable();
            $table->string('degree_level')->nullable();
            $table->date('application_deadline')->nullable();
            $table->string('external_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
