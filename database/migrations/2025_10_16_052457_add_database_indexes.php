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
        Schema::table('users', function (Blueprint $table) {
            $table->index('role'); // For filtering by role (admin/student)
            $table->index('status'); // For filtering by status
            $table->index(['role', 'status']); // Composite index for common queries
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->index('user_id'); // For joining with users
            $table->index('created_at'); // For ordering by enrollment date
        });

        Schema::table('strands', function (Blueprint $table) {
            $table->index('department_id'); // For filtering by department
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['status']);
            $table->dropIndex(['role', 'status']);
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('strands', function (Blueprint $table) {
            $table->dropIndex(['department_id']);
        });
    }
};
