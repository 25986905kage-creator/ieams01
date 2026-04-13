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
        Schema::create('alumni_engagements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('graduate_id')->constrained('graduates')->cascadeOnDelete();
            $table->boolean('aware_of_alumni_assoc')->default(false);
            $table->boolean('wants_to_join_alumni')->default(false);
            $table->string('personal_email')->nullable();
            $table->string('work_email')->nullable();
            $table->text('postal_address')->nullable();
            $table->string('primary_mobile_number')->nullable();
            $table->string('secondary_mobile_number')->nullable();
            $table->string('landline_number')->nullable();
            $table->string('primary_social_media')->nullable();
            $table->string('secondary_social_media')->nullable();
            $table->string('tertiary_social_media')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_engagements');
    }
};
