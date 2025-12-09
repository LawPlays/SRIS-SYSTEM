<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Add missing columns that are required for enrollment form
            if (!Schema::hasColumn('enrollments', 'school_year')) {
                $table->string('school_year')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('enrollments', 'strand')) {
                $table->string('strand')->nullable()->after('school_year');
            }
            if (!Schema::hasColumn('enrollments', 'grade_level')) {
                $table->string('grade_level')->nullable()->after('strand');
            }
            if (!Schema::hasColumn('enrollments', 'lrn')) {
                $table->string('lrn')->nullable()->after('middle_name');
            }
            if (!Schema::hasColumn('enrollments', 'age')) {
                $table->integer('age')->nullable()->after('sex');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Drop the columns if they exist
            $columns = ['school_year', 'strand', 'grade_level', 'lrn', 'age'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('enrollments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
