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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_id')->constrained()->cascadeOnDelete();
            $table->string('accepted_student_id');
            $table->string('spa_student_id');
            $table->string('name');
            $table->string('gender');
            $table->string('student_nrc_no')->nullable();
            $table->date('student_dob');
            $table->string('ethnic')->nullable();
            $table->string('religion')->nullable();
            $table->string('father_name');
            $table->string('father_nrc_no')->nullable();
            $table->string('mother_name');
            $table->string('mother_nrc_no')->nullable();
            $table->string('father_job')->nullable();
            $table->string('mother_job')->nullable();
            $table->string('wanted_class')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_phone_no')->nullable();
            $table->string('passed_grade_and_roll_no')->nullable();
            $table->string('passed_school_name')->nullable();
            $table->string('passed_year')->nullable();
            $table->string('passed_town_name')->nullable();
            $table->string('enter_date')->nullable();
            $table->string('available_people')->nullable();
            $table->string('image')->nullable();
            $table->softDeletes(); // Adds a 'deleted_at' column for soft deletes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
