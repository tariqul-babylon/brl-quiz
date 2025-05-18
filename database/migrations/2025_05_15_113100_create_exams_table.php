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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('tagline');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->text('instruction')->nullable(); // assuming nullable for flexibility
            $table->integer('full_mark');
            $table->float('negative_mark')->default(0);
            $table->time('duration');

            // Booleans (true/false values)
            $table->boolean('is_bluer')->default(false);
            $table->boolean('is_timer')->default(false);
            $table->boolean('exam_status')->default(false);
            $table->boolean('user_result_view')->default(false);
            $table->boolean('user_answer_view')->default(false);
            $table->boolean('is_question_random')->default(false);
            $table->boolean('is_option_random')->default(false);
            $table->boolean('is_sign_in_required')->default(false);
            $table->boolean('is_specific_student')->default(false);

            // Other fields
            $table->string('id_no_placeholder')->nullable();
            $table->string('logo')->nullable();
            $table->string('exam_link')->nullable();
            $table->string('exam_code')->unique();

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
