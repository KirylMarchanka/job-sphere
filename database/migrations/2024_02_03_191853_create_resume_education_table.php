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
        Schema::create('resume_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->references('id')->on('resumes')->cascadeOnDelete();
            $table->foreignId('educational_institution_id')->references('id')->on('educational_institutions')->cascadeOnDelete();
            $table->string('department')->comment('Факультет');
            $table->string('specialization')->comment('Специализация');
            $table->unsignedTinyInteger('degree')->comment('Уровень образования, 0 - среднее, 1 - среднее-специальное, 2 - Неоконченное высшее, 3 - Высшее, 4 - Бакалавр, 5 - Магистр, 6 - Кандидат наук, 7 - Доктор наук');
            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_education');
    }
};
