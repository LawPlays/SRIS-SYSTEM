<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            if (!Schema::hasColumn('enrollments', 'status')) {
                $table->string('status')->default('pending');
            }
            if (!Schema::hasColumn('enrollments', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
            if (!Schema::hasColumn('enrollments', 'waitlisted_at')) {
                $table->timestamp('waitlisted_at')->nullable();
            }
            if (!Schema::hasColumn('enrollments', 'reviewed_by')) {
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('enrollments', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
            if (!Schema::hasColumn('enrollments', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            foreach (['approved_at','waitlisted_at','reviewed_by','rejection_reason','rejected_at'] as $col) {
                if (Schema::hasColumn('enrollments', $col)) {
                    if ($col === 'reviewed_by') {
                        $table->dropConstrainedForeignId('reviewed_by');
                    } else {
                        $table->dropColumn($col);
                    }
                }
            }
        });
    }
};

