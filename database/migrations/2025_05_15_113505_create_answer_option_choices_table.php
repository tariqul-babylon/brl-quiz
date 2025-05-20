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
        Schema::create('answer_option_choices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('answer_option_id');
            $table->unsignedBigInteger('exam_question_option_id');

            $table->unique(['answer_option_id', 'exam_question_option_id'], 'answer_choice_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_option_choices');
    }
};
