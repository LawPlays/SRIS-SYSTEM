<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            if (!Schema::hasColumn('enrollments', 'is_4ps')) {
                $table->boolean('is_4ps')->default(false);
            }
            if (!Schema::hasColumn('enrollments', 'is_pwd')) {
                $table->boolean('is_pwd')->default(false);
            }
            if (!Schema::hasColumn('enrollments', 'disability_type')) {
                $table->string('disability_type')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            if (Schema::hasColumn('enrollments', 'is_4ps')) {
                $table->dropColumn('is_4ps');
            }
            if (Schema::hasColumn('enrollments', 'is_pwd')) {
                $table->dropColumn('is_pwd');
            }
            if (Schema::hasColumn('enrollments', 'disability_type')) {
                $table->dropColumn('disability_type');
            }
        });
    }
};
