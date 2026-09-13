<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('admin_action_logs');

        Schema::create('admin_action_logs', function (Blueprint $table) {
            $table->bigIncrements('log_id');

            $table->unsignedBigInteger('admin_id')->nullable();

            $table->string('action_type', 100);
            $table->string('target_table', 100)->nullable();
            $table->unsignedBigInteger('target_id')->nullable();

            $table->json('details')->nullable();

            $table->timestamp('created_at')->nullable();

            $table->foreign('admin_id')
                ->references('user_id')
                ->on('users')
                ->nullOnDelete();

            $table->index('action_type');
            $table->index(['target_table', 'target_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_action_logs');

        Schema::create('admin_action_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};