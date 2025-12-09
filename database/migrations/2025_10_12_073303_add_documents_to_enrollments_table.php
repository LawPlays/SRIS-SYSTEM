<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Add PSA Birth Certificate column if it doesn't exist
            if (!Schema::hasColumn('enrollments', 'psa_birth_certificate')) {
                $table->string('psa_birth_certificate')->nullable()->after('is_pwd');
            }

            // Add Form 137 column if it doesn't exist
            if (!Schema::hasColumn('enrollments', 'form137')) {
                $table->string('form137')->nullable()->after('psa_birth_certificate');
            }
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Drop the columns safely
            if (Schema::hasColumn('enrollments', 'psa_birth_certificate')) {
                $table->dropColumn('psa_birth_certificate');
            }

            if (Schema::hasColumn('enrollments', 'form137')) {
                $table->dropColumn('form137');
            }
        });
    }
};
