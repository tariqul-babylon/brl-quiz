@extends('front.layouts.app')

@section('content')
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results - Student Answer View</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        :root {
            --primary: #4285F4;
            --success: #34A853;
            --danger: #EA4335;
            --warning: #FBBC05;
            --dark: #202124;
            --light-bg: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header Section */
        .exam-header {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin-bottom: 24px;
        }

        .exam-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .exam-tagline {
            color: #5f6368;
            margin-bottom: 0;
        }

        .exam-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 8px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .meta-icon {
            color: #5f6368;
        }

        /* Student Info Section */
        .student-info-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin-bottom: 24px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .student-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .student-name {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .student-meta {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .stat-item {
            padding: 12px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-correct {
            background: #E6F4EA;
            color: var(--success);
        }

        .stat-incorrect {
            background: #FCE8E6;
            color: var(--danger);
        }

        .stat-neutral {
            background: #FEF7E0;
            color: var(--warning);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 0.85rem;
        }

        .questions-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .question {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .question:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .question-title {
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--dark);
        }

        .question-meta {
            display: flex;
            gap: 10px;
            width: 200px;
            justify-content: flex-end;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .correct-badge {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success);
        }

        .incorrect-badge {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger);
        }

        .unanswered-badge {
            background-color: rgba(248, 150, 30, 0.1);
            color: var(--warning);
        }

        .options-list {
            list-style-type: none;
        }

        .option {
            padding: 12px 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            position: relative;
            padding-left: 45px;
        }

        .option.selected {
            border-color: var(--primary);
            background-color: rgba(67, 97, 238, 0.05);
        }

        .option.correct {
            border-color: var(--success);
            background-color: rgba(76, 201, 240, 0.05);
        }

        .option.incorrect {
            border-color: var(--danger);
            background-color: rgba(247, 37, 133, 0.05);
        }

        .option-radio {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            border: 2px solid #adb5bd;
            border-radius: 50%;
        }

        .option.selected .option-radio {
            border-color: var(--primary);
        }

        .option.selected .option-radio::after {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: var(--primary);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .option.correct .option-radio {
            border-color: var(--success);
        }

        .option.correct .option-radio::after {
            content: '✓';
            position: absolute;
            color: var(--success);
            font-size: 0.8rem;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @media (max-width: 768px) {

            .info-grid,
            .score-grid {
                grid-template-columns: 1fr;
            }

            .final-score {
                grid-column: span 1;
            }

            .header h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
<div class="container mt-4 mb-5">
    <!-- Exam Header -->
    <div class="exam-header">
        <h1 class="exam-title">
            <span class="material-icons">quiz</span>
            {{ $answer->exam->title ?? 'N/A' }}
        </h1>
        <p class="exam-tagline">{{ $answer->exam->tagline ?? 'N/A' }}</p>

        <div class="exam-meta">
            <div class="meta-item">
                <span class="material-icons meta-icon">schedule</span>
                <span>Duration: {{ $answer->exam->duration ?? 'N/A' }}</span>
            </div>
            <div class="meta-item">
                <span class="material-icons meta-icon">grade</span>
                <span>Mark per Question: {{ $answer->exam->mark_per_question ?? 'N/A' }}</span>
            </div>
            <div class="meta-item">
                <span class="material-icons meta-icon">warning</span>
                <span>Negative Mark: {{ $answer->exam->negative_mark ?? '0' }}</span>
            </div>
        </div>
    </div>

    <!-- Student Information -->
    <div class="student-info-card">
        <div class="student-section">
            <div class="student-header">
                <span class="material-icons">person</span>
                <h3 class="student-name">{{ $answer->name }}</h3>
            </div>
            <div class="student-meta">
                <div><strong>ID:</strong> {{ $answer->id_no }}</div>
                <div><strong>Contact:</strong> {{ $answer->contact }}</div>
                <div><strong>Joined At:</strong> {{ $answer->join_at ? \Carbon\Carbon::parse($answer->join_at)->format('Y-m-d H:i') : 'N/A' }}</div>
                <div><strong>Submitted At:</strong> {{ $answer->end_at ? \Carbon\Carbon::parse($answer->end_at)->format('Y-m-d H:i') : 'N/A' }}</div>
                <div><strong>Time Spent:</strong> {{ \Carbon\CarbonInterval::createFromFormat('H:i:s.u', $answer->duration)->format('%I:%S') }}</div>
            </div>
        </div>

        <div class="stats-section">
            <div class="stat-grid">
                <div class="stat-item stat-correct">
                    <div class="stat-value">{{ $answer->correct_ans }}</div>
                    <div class="stat-label">Correct</div>
                </div>
                <div class="stat-item stat-incorrect">
                    <div class="stat-value">{{ $answer->incorrect_ans }}</div>
                    <div class="stat-label">Incorrect</div>
                </div>
                <div class="stat-item stat-neutral">
                    <div class="stat-value">{{ $answer->not_answered }}</div>
                    <div class="stat-label">Unanswered</div>
                </div>
            </div>

            <div style="margin-top: 16px;">
                <div><strong>Full Mark:</strong> {{ $answer->full_mark }}</div>
                <div><strong>Obtained Mark:</strong> {{ $answer->obtained_mark }}</div>
                <div><strong>Penalty:</strong> -{{ $answer->negative_mark }}</div>
                <div style="font-size: 1.2rem; margin-top: 8px;">
                    <strong>Final Mark:</strong> <span style="color: var(--primary);">{{ $answer->final_obtained_mark }}</span>
                </div>
            </div>
        </div>
    </div>


    <!-- Questions Review -->
    <section class="questions-container">
        <h2>Question Detail</h2>

        @foreach ($answer->answerOptions as $index => $answerOption)
            @php
                $question = $answerOption->question;
            @endphp
            <div class="question">
                <div class="question-header">
                    <div class="question-title">{{ $index + 1 }}: {{ $question ? ($question->title ?? 'N/A') : 'Question Not Found' }}</div>
                    <div class="question-meta">
                        @if ($answerOption->answer_status == \App\Models\AnswerOption::CORRECT)
                            <span class="status-badge correct-badge">Correct</span>
                        @elseif ($answerOption->answer_status == \App\Models\AnswerOption::INCORRECT)
                            <span class="status-badge incorrect-badge">Incorrect</span>
                        @else
                            <span class="status-badge unanswered-badge">Unanswered</span>
                        @endif
                        <span>
                            Mark:
                            @if ($answerOption->answer_status == \App\Models\AnswerOption::CORRECT)
                                {{ $answer->exam->mark_per_question ?? 'N/A' }}
                            @elseif ($answerOption->answer_status == \App\Models\AnswerOption::INCORRECT)
                                {{ '-'.$answer->exam->negative_mark ?? '0' }}
                            @else
                                <span class="text-danger">0</span>
                            @endif
                        </span>
                    </div>
                </div>
                @if($question)
                    <ul class="options-list">
                        @if($question->options->isNotEmpty())
                            @foreach($question->options as $option)
                                @php
                                    $isSelected = $answerOption->answerOptionChoices
                                        ->pluck('exam_question_option_id')
                                        ->contains($option->id);
                                    $isCorrect = $option->is_correct;

                                    $classes = 'option';
                                    if ($isSelected) $classes .= ' selected';
                                    if ($isCorrect) $classes .= ' correct';
                                    elseif ($isSelected && !$isCorrect) $classes .= ' incorrect';
                                @endphp

                                <li class="{{ $classes }}">
                                    <span class="option-radio"></span>
                                    {{ $option->title }}
                                </li>
                            @endforeach

                        @else
                            <p>No options available for this question.</p>
                        @endif
                    </ul>
                @else
                    <p class="text-danger">This question is missing or has been deleted.</p>
                @endif
            </div>
        @endforeach
    </section>


</div>
</body>

</html>
@endsection
