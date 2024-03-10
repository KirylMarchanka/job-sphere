<?php

use App\Components\Resume\Enums\EmploymentEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employer_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')
                ->references('id')
                ->on('employers')
                ->cascadeOnDelete();
            $table->string('title');
            $table->unsignedInteger('salary_from')->nullable();
            $table->unsignedInteger('salary_to')->nullable();
            $table->boolean('salary_employer_paid_taxes')->default(false);
            $table->unsignedTinyInteger('experience')->nullable();
            $table->unsignedTinyInteger('education')->nullable();
            $table->unsignedTinyInteger('schedule');
            $table->longText('description');
            $table->foreignId('city_id')->references('id')->on('cities')->cascadeOnDelete();
            $table->string('street')->nullable();
            $table->unsignedTinyInteger('employment')->default(EmploymentEnum::FULL_TIME->value);
            $table->boolean('is_archived')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employer_jobs');
    }
};
