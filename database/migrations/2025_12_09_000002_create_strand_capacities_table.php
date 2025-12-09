<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('strand_capacities', function (Blueprint $table) {
            $table->id();
            $table->string('school_year');
            $table->string('grade_level');
            $table->string('strand');
            $table->unsignedInteger('capacity');
            $table->timestamps();
            $table->unique(['school_year','grade_level','strand']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('strand_capacities');
    }
};

