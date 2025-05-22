@extends('front.layouts.app')
@push('css')
    <style>
        :root {
            --primary: #4285F4;
            --danger: #EA4335;
            --success: #34A853;
            --warning: #FBBC05;
            --dark: #202124;
            --light-bg: #f8f9fa;
            --correct: #E6F4EA;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .exam-header-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 24px;
            margin-bottom: 24px;
        }

        .exam-title {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .exam-tagline {
            color: #5f6368;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .exam-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .meta-icon {
            color: #5f6368;
        }

        .meta-label {
            font-size: 0.9rem;
            color: #5f6368;
        }

        .meta-value {
            font-weight: 500;
            margin-top: 2px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-top: 16px;
        }

        .status-active {
            background: #E6F4EA;
            color: #34A853;
        }

        .status-pending {
            background: #FEF7E0;
            color: #FBBC05;
        }

        /* Questions Section */
        .questions-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 24px;
        }

        .section-title {
            font-size: 1.2rem;
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .question-card {
            padding: 16px;
            margin-bottom: 20px;
            border: 1px solid #f1f3f4;
            border-radius: 8px;
        }

        .question-text {
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 16px;
            display: flex;
            gap: 8px;
        }

        .question-number {
            color: var(--primary);
            font-weight: 600;
        }

        .options-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .option-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 4px;
            background: #f8f9fa;
            gap: 8px;
        }

        .option-item.correct {
            background: var(--correct);
            border-left: 3px solid var(--success);
        }

        .option-letter {
            font-weight: 600;
            color: #5f6368;
        }

        .correct-icon {
            color: var(--success);
            margin-left: auto;
        }

        @media (max-width: 600px) {
            .exam-meta {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')


    <div class="container mt-4 my-5">
        <!-- Exam Header -->
        <div class="exam-header-card">
            <div class="d-flex justify-content-between flex-wrap align-items-start">
                <div>
                    <table class="table mb-0 table-borderless table-sm">
                        <tr>
                            <td>Exam Code: <b>{{ $exam->exam_code }}</b></td>
                        </tr>
                        <tr>
                            <td><h1 class="exam-title m-0">{{ $exam->title }}</h1></td>
                        </tr>
                        <tr>
                            <td><div class="text-muted">{{ $exam->tagline }}</div></td>
                        </tr>
                    </table>
                </div>
                <div class="text-end text-muted">
                    <small>Exam Status </small> <br>
                    @if($exam->exam_status == 1)
                        <span class="badge bg-secondary">Draft</span>
                    @elseif($exam->exam_status == 2)
                        <span class="badge bg-success">Published</span>
                    @elseif($exam->exam_status == 3)
                        <span class="badge bg-success">Closed</span>
                    @endif

                </div>
            </div>

            <hr class="my-2">

            <div class="exam-meta">
                <div class="meta-item">
                    <span class="material-symbols-outlined meta-icon">schedule</span>
                    <div>
                        <div class="meta-label">Duration</div>
                        <div class="meta-value">{{ $exam->duration }}</div>
                    </div>
                </div>
                <div class="meta-item">
                    <span class="material-symbols-outlined meta-icon">grade</span>
                    <div>
                        <div class="meta-label">Marks per Question</div>
                        <div class="meta-value">{{ $exam->mark_per_question }}</div>
                    </div>
                </div>
                @if($exam->negative_mark)
                    <div class="meta-item">
                        <span class="material-symbols-outlined meta-icon">remove_circle</span>
                        <div>
                            <div class="meta-label">Negative Marking</div>
                            <div class="meta-value">{{ $exam->negative_mark }}</div>
                        </div>
                    </div>
                @endif

                @if($exam->id_no_placeholder)
                    <div class="meta-item">
                        <span class="material-symbols-outlined meta-icon">badge</span>
                        <div>
                            <div class="meta-label">Registration Number</div>
                            <div class="meta-value">{{ $exam->id_no_placeholder }}</div>
                        </div>
                    </div>
                @endif

                @if($exam->is_question_random)
                    <div class="meta-item">
                        <span class="material-symbols-outlined meta-icon">shuffle</span>
                        <div>
                            <div class="meta-label">Question Order</div>
                            <div class="meta-value">Randomized</div>
                        </div>
                    </div>
                @endif
                @if($exam->user_result_view)
                    <div class="meta-item">
                        <span class="material-symbols-outlined meta-icon">visibility</span>
                        <div>
                            <div class="meta-label">Results</div>
                            <div class="meta-value">Visible to Students</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Questions Section -->
        <div class="questions-container">
            <h2 class="section-title">
                <span class="material-symbols-outlined">quiz</span>
                Exam Questions
            </h2>

            @forelse($exam->questions as $index => $question)
                <div class="question-card">
                    <div class="question-text">
                        <span class="question-number">Q{{ $index + 1 }}.</span>
                        {{ $question->title }}
                    </div>
                    <div class="options-list">
                        @foreach($question->options as $optIndex => $option)
                            @php
                                $isCorrect = $option->is_correct;
                                $optionLetter = chr(65 + $optIndex); // A, B, C, D...
                            @endphp
                            <div class="option-item {{ $isCorrect ? 'correct' : '' }}">
                                <span class="option-letter">{{ $optionLetter }})</span>
                                {{ $option->title }}
                                @if($isCorrect)
                                    <span class="material-symbols-outlined correct-icon">check_circle</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p>No questions available for this exam.</p>
            @endforelse
        </div>


        <a href="{{ route('exams.index') }}" class="btn mt-3 btn-outline-secondary d-inline-flex align-items-center gap-2">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Exams List
        </a>
    </div>


@endsection
