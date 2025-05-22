@extends('front.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('scss/main.css') }}">
    <style>
        .exam-details p, .answer-details p {
            margin-bottom: 0.5rem;
        }
        .options label {
            padding: 5px 0;
        }
        .text-success {
            color: #28a745 !important;
            font-weight: bold;
        }
        .text-danger {
            color: #dc3545 !important;
            font-weight: bold;
        }
        .badge {
            margin-left: 10px;
            vertical-align: middle;
        }
        .card-header {
            background-color: #f8f9fa;
        }
        .card-body {
            padding: 1.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h2 class="mb-4">Result Details</h2>

        <!-- Exam Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title">{{ $answer->exam->title ?? 'Exam Not Found' }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 exam-details">
                        <h5>Exam Information</h5>
                        <p><strong>Title:</strong> {{ $answer->exam->title ?? 'N/A' }}</p>
                        <p><strong>Tagline:</strong> {{ $answer->exam->tagline ?? 'N/A' }}</p>
                        <p><strong>Start Time:</strong> {{ $answer->exam->start_at ? \Carbon\Carbon::parse($answer->exam->start_at)->format('Y-m-d H:i') : 'N/A' }}</p>
                        <p><strong>End Time:</strong> {{ $answer->exam->end_at ? \Carbon\Carbon::parse($answer->exam->end_at)->format('Y-m-d H:i') : 'N/A' }}</p>
                        <p><strong>Duration:</strong> {{ $answer->exam->duration ?? 'N/A' }}</p>
                        <p><strong>Mark per Question:</strong> {{ $answer->exam->mark_per_question ?? 'N/A' }}</p>
                        <p><strong>Negative Mark:</strong> {{ $answer->exam->negative_mark ?? '0' }}</p>
                    </div>
                    <div class="col-md-6 answer-details">
                        <h5>Your Performance</h5>
                        <p><strong>Final Score:</strong> {{ $answer->final_obtained_mark ?? '0' }}</p>
                        <p><strong>Full Marks:</strong> {{ $answer->full_mark ?? '0' }}</p>
                        <p><strong>Correct Answers:</strong> {{ $answer->correct_ans ?? '0' }}</p>
                        <p><strong>Incorrect Answers:</strong> {{ $answer->incorrect_ans ?? '0' }}</p>
                        <p><strong>Not Answered:</strong> {{ $answer->not_answered ?? '0' }}</p>
                        <p><strong>Joined At:</strong> {{ $answer->join_at ? \Carbon\Carbon::parse($answer->join_at)->format('Y-m-d H:i') : 'N/A' }}</p>
                        <p><strong>Ended At:</strong> {{ $answer->end_at ? \Carbon\Carbon::parse($answer->end_at)->format('Y-m-d H:i') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions and Options -->
        @foreach($answer->answerOptions as $index => $answerOption)
            @php
                $question = $answerOption->question;
            @endphp
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Question {{ $index + 1 }}: {{ $question ? ($question->title ?? 'N/A') : 'Question Not Found' }}</strong>
                    <span class="badge {{ $answerOption->answer_status == \App\Models\AnswerOption::CORRECT ? 'bg-success' : ($answerOption->answer_status == \App\Models\AnswerOption::INCORRECT ? 'bg-danger' : 'bg-secondary') }}">
                        {{ $answerOption->answer_status == \App\Models\AnswerOption::CORRECT ? 'Correct' : ($answerOption->answer_status == \App\Models\AnswerOption::INCORRECT ? 'Incorrect' : 'Not Answered') }}
                    </span>
                </div>
                <div class="card-body">
                    @if($question)
                        <p><strong>Question Type:</strong> {{ \App\Models\ExamQuestion::QUESTION_TYPE[$question->question_type] ?? 'N/A' }}</p>
                        <div class="options">
                            @if($question->options->isNotEmpty())
                                @foreach($question->options as $option)
                                    @php
                                        $isSelected = $answerOption->answerOptionChoices
                                            ->pluck('exam_question_option_id')
                                            ->contains($option->id);
                                        $isCorrect = $option->is_correct;
                                    @endphp
                                    <label class="d-block {{ $isCorrect ? 'text-success' : ($isSelected && !$isCorrect ? 'text-danger' : '') }}">
                                        <input
                                            type="checkbox"
                                            disabled
                                            {{ $isSelected ? 'checked' : '' }}
                                        >
                                        {{ $option->title }}
                                        @if($isCorrect)
                                            <span class="badge bg-success">Correct</span>
                                        @endif
                                        @if($isSelected && !$isCorrect)
                                            <span class="badge bg-danger">Incorrect</span>
                                        @endif
                                    </label>
                                @endforeach
                            @else
                                <p>No options available for this question.</p>
                            @endif
                        </div>
                    @else
                        <p class="text-danger">This question is missing or has been deleted.</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
