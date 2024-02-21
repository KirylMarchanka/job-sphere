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
        Schema::create('resume_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->references('id')->on('resumes')->cascadeOnDelete();
            $table->string('company_name');
            $table->foreignId('city_id')->nullable()->references('id')->on('cities')->cascadeOnDelete();
            $table->string('position');
            $table->string('site_url')->nullable();
            $table->text('description')->nullable();
            $table->date('from');
            $table->date('to')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_work_experiences');
    }
};
