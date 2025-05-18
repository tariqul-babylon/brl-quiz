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
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->string('title');
            $table->boolean('question_type');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->unique(['exam_id', 'title'], 'exam_title_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
