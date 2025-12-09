<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            if (!Schema::hasColumn('enrollments', 'ip_community')) {
                $table->string('ip_community')->nullable()->after('sex');
            }
            if (!Schema::hasColumn('enrollments', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('guardian_name');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('enrollments', 'is_4ps_beneficiary')) {
                $table->boolean('is_4ps_beneficiary')->default(false)->after('user_id');
            }
            if (!Schema::hasColumn('enrollments', 'is_pwd')) {
                $table->boolean('is_pwd')->default(false)->after('is_4ps_beneficiary');
            }
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['ip_community', 'user_id', 'is_4ps_beneficiary', 'is_pwd']);
        });
    }
};
