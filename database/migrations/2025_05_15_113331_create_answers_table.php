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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name', 150);
            $table->string('id_no', 50);
            $table->string('contact', 20);
            $table->boolean('exam_stats');
            $table->dateTime('join_at', 3);
            $table->dateTime('end_at', 3);
            $table->dateTime('duration');
            $table->integer('correct_ans');
            $table->integer('incorrect_ans');
            $table->integer('not_answered');
            $table->boolean('end_method');
            $table->timestamps();
            $table->softDeletes();

            // Composite unique constraint
            $table->unique(['exam_id', 'user_id'], 'answers_exam_user_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
