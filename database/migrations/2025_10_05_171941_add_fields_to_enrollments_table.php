<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {

            if (!Schema::hasColumn('enrollments', 'mother_tongue')) {
                $table->string('mother_tongue')->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'ip_community')) {
                $table->string('ip_community')->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'is_4ps')) {
                $table->boolean('is_4ps')->default(false);
            }

            if (!Schema::hasColumn('enrollments', 'is_pwd')) {
                $table->boolean('is_pwd')->default(false);
            }

            if (!Schema::hasColumn('enrollments', 'disability_type')) {
                $table->string('disability_type')->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'current_address')) {
                $table->string('current_address')->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'permanent_address')) {
                $table->string('permanent_address')->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'father_name')) {
                $table->string('father_name')->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'mother_name')) {
                $table->string('mother_name')->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'guardian_name')) {
                $table->string('guardian_name')->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'contact_number')) {
                $table->string('contact_number', 20)->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'email')) {
                $table->string('email')->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'psa_birth_certificate')) {
                $table->string('psa_birth_certificate')->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'form137')) {
                $table->string('form137')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $columns = [
                'mother_tongue', 'ip_community', 'is_4ps', 'is_pwd', 'disability_type',
                'current_address', 'permanent_address', 'father_name', 'mother_name',
                'guardian_name', 'contact_number', 'email', 'psa_birth_certificate', 'form137'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('enrollments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
