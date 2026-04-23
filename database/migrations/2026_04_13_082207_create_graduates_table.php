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
            $table->id()->index()->index();
            $table->string('student_number')->unique()->index();
            $table->string('sevispass_id')->nullable()->unique()->index();
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->string('name_used_at_uni')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable()->index();
            $table->string('nationality')->nullable()->index();
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
