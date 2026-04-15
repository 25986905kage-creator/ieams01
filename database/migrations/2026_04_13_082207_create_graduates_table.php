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
        Schema::create('graduates', function (Blueprint $table) {
            $table->id();
            $table->string('student_number')->unique();
            $table->string('sevispass_id')->nullable()->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('university_name')->nullable();
            $table->string('course')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('pob_country')->nullable();
            $table->string('home_province')->nullable();
            $table->string('pre_uni_city')->nullable();
            $table->string('previous_school_name')->nullable();
            $table->boolean('is_first_gen_family')->default(false);
            $table->boolean('is_first_gen_village')->default(false);
            $table->string('father_education_level')->nullable();
            $table->string('mother_education_level')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graduates');
    }
};
