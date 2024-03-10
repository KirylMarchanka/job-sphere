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
        Schema::create('job_applies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->references('id')->on('resumes')->cascadeOnDelete();
            $table->foreignId('employer_job_id')->references('id')->on('employer_jobs')->cascadeOnDelete();
            $table->unsignedTinyInteger('type')->comment('Тип отклика: 0 - приглашение от компании, 1 - отклик от пользователя');
            $table->unsignedTinyInteger('status')->default(0)->comment('Статус отклика, 0 - Ожидает рассмотрения, 1 - Отклонен, 2 - Приглашен');
            $table->timestamp('created_at')->nullable();

            $table->unique(['resume_id', 'employer_job_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applies');
    }
};
