<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                ALTER TABLE student_profiles
                MODIFY degree_level
                ENUM('diploma','high_school','bachelor','master','phd','other')
                NULL
            ");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                ALTER TABLE student_profiles
                MODIFY degree_level
                ENUM('high_school','bachelor','master','phd','other')
                NULL
            ");
        }
    }
};