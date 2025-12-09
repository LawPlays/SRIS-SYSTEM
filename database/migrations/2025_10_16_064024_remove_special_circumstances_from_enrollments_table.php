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
            // Only drop columns that exist
            if (Schema::hasColumn('enrollments', 'ip_community')) {
                $table->dropColumn('ip_community');
            }
            if (Schema::hasColumn('enrollments', 'is_indigenous')) {
                $table->dropColumn('is_indigenous');
            }
            if (Schema::hasColumn('enrollments', 'indigenous_specify')) {
                $table->dropColumn('indigenous_specify');
            }
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->string('ip_community')->nullable();
            $table->boolean('is_indigenous')->default(false);
            $table->string('indigenous_specify')->nullable();
            $table->boolean('is_4ps')->default(false);
            $table->boolean('is_pwd')->default(false);
            $table->string('disability_type')->nullable();
        });
    }
};
