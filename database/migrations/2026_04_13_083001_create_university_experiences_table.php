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
        Schema::create('university_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('graduate_id')->constrained('graduates')->cascadeOnDelete();
            $table->boolean('has_leadership_experience')->default(false);
            $table->text('leadership_role_description')->nullable();
            $table->boolean('is_student_volunteer')->default(false);
            $table->boolean('is_education_adequate')->default(false);
            $table->string('rating_employment_potential')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('university_experiences');
    }
};
