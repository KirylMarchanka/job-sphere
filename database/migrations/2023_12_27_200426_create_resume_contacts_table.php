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
        Schema::create('resume_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->references('id')->on('resumes')->cascadeOnDelete();
            $table->string('mobile_number', 21);
            $table->string('comment')->nullable();
            $table->string('email', 254)->nullable();
            $table->unsignedTinyInteger('preferred_contact_source')->default(0);
            $table->json('other_sources')->nullable();

            $table->unique(['resume_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_contacts');
    }
};
