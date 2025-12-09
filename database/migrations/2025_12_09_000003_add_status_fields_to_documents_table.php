<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'status')) {
                $table->string('status')->default('submitted');
            }
            if (!Schema::hasColumn('documents', 'remarks')) {
                $table->text('remarks')->nullable();
            }
            if (!Schema::hasColumn('documents', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('documents', 'verified_at')) {
                $table->timestamp('verified_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            foreach (['status','remarks','verified_by','verified_at'] as $col) {
                if (Schema::hasColumn('documents', $col)) {
                    if ($col === 'verified_by') {
                        $table->dropConstrainedForeignId('verified_by');
                    } else {
                        $table->dropColumn($col);
                    }
                }
            }
        });
    }
};

