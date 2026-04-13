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
            $table->id();
            $table->foreignId('graduate_id')->constrained('graduates')->cascadeOnDelete();
            $table->string('sat_teaching_quality')->nullable();
            $table->string('sat_faculty_interaction')->nullable();
            $table->string('sat_career_assistance')->nullable();
            $table->string('sat_employment_assistance')->nullable();
            $table->string('sat_faculty_mentorship')->nullable();
            $table->string('exp_oral_presentation')->nullable();
            $table->string('exp_problem_solving')->nullable();
            $table->string('exp_practical_learning')->nullable();
            $table->string('exp_innovation_modeling')->nullable();
            $table->string('impact_communication')->nullable();
            $table->string('impact_problem_solving')->nullable();
            $table->string('impact_teamwork')->nullable();
            $table->string('impact_tech_knowledge')->nullable();
            $table->string('exp_industry_networking')->nullable();
            $table->string('exp_alumni_networking')->nullable();
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
