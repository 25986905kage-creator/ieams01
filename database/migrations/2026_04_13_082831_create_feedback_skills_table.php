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
        Schema::create('feedback_skills', function (Blueprint $table) {
            $table->id()->index();
            $table->foreignId('graduate_id')->constrained('graduates')->cascadeOnDelete();
            $table->unsignedTinyInteger('sat_teaching_quality')->nullable();
            $table->unsignedTinyInteger('sat_faculty_interaction')->nullable();
            $table->unsignedTinyInteger('sat_career_assistance')->nullable();
            $table->unsignedTinyInteger('sat_employment_assistance')->nullable();
            $table->unsignedTinyInteger('sat_faculty_mentorship')->nullable();
            $table->unsignedTinyInteger('exp_oral_presentation')->nullable();
            $table->unsignedTinyInteger('exp_problem_solving')->nullable();
            $table->unsignedTinyInteger('exp_practical_learning')->nullable();
            $table->unsignedTinyInteger('exp_innovation_modeling')->nullable();
            $table->unsignedTinyInteger('impact_communication')->nullable();
            $table->unsignedTinyInteger('impact_problem_solving')->nullable();
            $table->unsignedTinyInteger('impact_teamwork')->nullable();
            $table->unsignedTinyInteger('impact_tech_knowledge')->nullable();
            $table->unsignedTinyInteger('exp_industry_networking')->nullable();
            $table->unsignedTinyInteger('exp_alumni_networking')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_skills');
    }
};
