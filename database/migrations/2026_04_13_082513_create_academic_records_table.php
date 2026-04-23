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
        Schema::create('academic_records', function (Blueprint $table) {
            $table->id()->index();
            $table->foreignId('graduate_id')->constrained('graduates')->cascadeOnDelete();
            $table->string('degree_type')->nullable();
            $table->string('award_type')->nullable();
            $table->date('uni_start_date')->nullable();
            $table->date('uni_end_date')->nullable();
            $table->date('graduated_in_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_records');
    }
};
