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
            $table->decimal('mark_per_question', 10, 2);
            $table->decimal('negative_mark', 10,2)->nullable();
            $table->time('duration');

            // Booleans (true/false values)
            $table->boolean('is_bluer')->nullable();
            $table->boolean('is_timer')->nullable();
            $table->boolean('exam_status')->nullable();
            $table->boolean('user_result_view')->nullable();
            $table->boolean('user_answer_view')->nullable();
            $table->boolean('is_question_random')->nullable();
            $table->boolean('is_option_random')->nullable();
            $table->boolean('is_sign_in_required')->nullable();
            $table->boolean('is_specific_student')->nullable();

            // Other fields
            $table->string('id_no_placeholder')->nullable();
            $table->string('logo')->nullable();
            $table->string('exam_link')->nullable();
            $table->string('exam_code')->unique();
            $table->boolean('exam_source')->default(1);

            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
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
