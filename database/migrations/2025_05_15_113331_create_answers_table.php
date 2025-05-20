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
            $table->foreignId('exam_id')->constrained('exams');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('name', 150);
            $table->string('id_no', 50)->nullable();
            $table->string('contact', 20)->nullable();
            $table->dateTime('join_at', 6);
            $table->dateTime('end_at', 6)->nullable();
            $table->time('duration',6)->nullable();
            $table->integer('correct_ans')->nullable();
            $table->integer('incorrect_ans')->nullable();
            $table->integer('not_answered')->nullable();

            $table->integer('full_mark')->nullable();
            $table->integer('obtained_mark')->nullable();
            $table->integer('negative_mark')->nullable();
            $table->integer('final_obtained_mark')->nullable();

            $table->boolean('end_method')->nullable();
            $table->string('exam_token')->nullable();
            $table->boolean('exam_status')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();

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
