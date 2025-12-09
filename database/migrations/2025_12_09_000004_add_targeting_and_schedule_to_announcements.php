<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            if (!Schema::hasColumn('announcements', 'publish_at')) {
                $table->timestamp('publish_at')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'expire_at')) {
                $table->timestamp('expire_at')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'audience_grade_level')) {
                $table->string('audience_grade_level')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'audience_strand')) {
                $table->string('audience_strand')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'audience_role')) {
                $table->string('audience_role')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            foreach (['publish_at','expire_at','audience_grade_level','audience_strand','audience_role'] as $col) {
                if (Schema::hasColumn('announcements', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};

