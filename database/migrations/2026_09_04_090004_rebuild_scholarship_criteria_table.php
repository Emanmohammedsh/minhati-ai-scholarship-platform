<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        Schema::dropIfExists('scholarship_criteria');

        Schema::create('scholarship_criteria', function (Blueprint $table) {
            $table->id('criterion_id');
            $table->unsignedBigInteger('scholarship_id');
            $table->string('criterion_type', 100);
            $table->string('criterion_value', 255);
            $table->decimal('weight', 5, 2)->default(0);
            $table->boolean('is_mandatory')->default(false);
            $table->timestamps();

            $table->foreign('scholarship_id')
                ->references('scholarship_id')->on('scholarships')
                ->cascadeOnDelete();
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarship_criteria');
    }
};
