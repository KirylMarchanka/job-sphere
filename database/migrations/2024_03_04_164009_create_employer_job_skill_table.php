<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employer_job_skill', function (Blueprint $table) {
            $table->foreignId('employer_job_id')->references('id')->on('employer_jobs')->cascadeOnDelete();
            $table->foreignId('skill_id')->references('id')->on('skills')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employer_job_skill');
    }
};
