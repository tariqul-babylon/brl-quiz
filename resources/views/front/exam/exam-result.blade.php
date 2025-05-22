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
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 1.5rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-filter {
            display: flex;
            gap: 10px;
        }

        .search-filter input {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 250px;
        }

        .result-cards {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .result-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 16px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 16px;
            transition: all 0.3s ease;
        }

        .student-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .student-name {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .student-meta {
            display: flex;
            gap: 16px;
            font-size: 0.85rem;
            color: #5f6368;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .exam-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #5f6368;
        }

        .stat-value {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .stat-correct {
            color: var(--success);
        }

        .stat-incorrect {
            color: var(--danger);
        }

        .stat-neutral {
            color: var(--warning);
        }

        .result-summary {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }

        .total-mark {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary);
        }

        .mark-details {
            font-size: 0.85rem;
            color: #5f6368;
            text-align: right;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            gap: 4px;
        }

        .status-completed {
            background: #E6F4EA;
            color: var(--success);
        }

        .status-pending {
            background: #FEF7E0;
            color: var(--warning);
        }

        .result-card-link {
            cursor: pointer;
        }

        .result-card:hover {
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
            transform: translateY(-2px);
        }

        @media (max-width: 900px) {
            .result-card {
                grid-template-columns: 1fr;
            }

            .result-summary {
                align-items: flex-start;
            }

            .mark-details {
                text-align: left;
            }

            .exam-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .search-filter {
                width: 100%;
            }

            .search-filter input {
                width: 100%;
                min-width: unset;
            }

            .student-meta {
                flex-direction: column;
                gap: 4px;
            }
        }

        .material-symbols-outlined {
            font-size: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4 mb-5">
        <div class="header align-items-start">
            <div>
                <h1 class="page-title mb-1">
                    <span class="material-symbols-outlined">assignment</span>
                    Results of {{ $exam->title }} Exam
                </h1>
                <hr class="my-1">

                <small>
                    <span>Duration : <b>{{ $exam->duration }}</b></span> |
                    <span>Full Mark : <b>{{ count($exam->questions) * $exam->mark_per_question }}</b></span>
                    <span>Negative Mark : <b >-{{ $exam->negative_mark }}</b></span>
                    <div>
                        @if($exam->exam_source == 1)
                            <span>Attended : <b>{{ $exam->participants->count() }}</b></span>
                        @endif

                        @if($exam->exam_source == 1)
                            <span>Submitted : <b>{{ $exam?->participants?->where('exam_status',2)?->count() }}</b></span>
                        @endif

                        @if($exam->exam_source == 1)
                            <span>Not Submitted : <b>{{ $exam?->participants?->where('exam_status',1)->count() }}</b></span>
                        @endif
                    </div>
                </small>
            </div>
            <form class=" d-flex align-items-center gap-2">
                <select name="" style="width: 150px;" class="form-select" >
                    <option value="">All Student</option>
                    @foreach (range(1, 20) as $rank)
                        <option value="{{ $rank }}"> {{ $rank }} Student Rank</option>
                    @endforeach
                </select>
                <button class="btn btn-success" style="width: 200px;">Get Student Rank</button>
            </form>
        </div>
        <div class="result-cards">

            @foreach ($answers as $answer)
                <!-- Result Card 1 -->
                <a href="{{ route('front.exam.results.show',$answer->id) }}" class="result-card text-decoration-none">
                    <div class="student-info">
                        <h3 class="student-name">
                            <span class="material-symbols-outlined">person</span>
                            {{ $answer->name }}
                        </h3>
                        <div class="student-meta">
                            <span class="meta-item">
                                <span class="material-symbols-outlined">badge</span>
                                ID: {{ $answer->id_no }}
                            </span>
                            <span class="meta-item">
                                <span class="material-symbols-outlined">phone</span>
                                {{ $answer->contact }}
                            </span>
                        </div>
                        <div class="student-meta">
                            <span class="meta-item">
                                <span class="material-symbols-outlined">schedule</span>
                                {{ \Carbon\CarbonInterval::createFromFormat('H:i:s.u', $answer->duration)->format('%I:%S') }}
                            </span>
                        </div>
                        <div class="student-meta">
                            <span class="text-decoration-none text-primary">Click to View Details</span>
                        </div>
                    </div>

                    <div class="exam-stats">
                        <div class="stat-item">
                            <span class="stat-label">Correct</span>
                            <span class="stat-value stat-correct">{{ $answer->correct_ans }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Incorrect</span>
                            <span class="stat-value stat-incorrect">{{ $answer->incorrect_ans }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Unanswered</span>
                            <span class="stat-value stat-neutral">{{ $answer->not_answered }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Full Mark</span>
                            <span class="stat-value">{{ $answer->full_mark }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Obtained</span>
                            <span class="stat-value">{{ $answer->obtained_mark }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Penalty</span>
                            <span class="stat-value stat-incorrect">-{{ $answer->negative_mark }}</span>
                        </div>
                    </div>

                    <div class="result-summary">
                        <span class="total-mark">{{ $answer->final_obtained_mark }}</span>
                        <span class="mark-details">Final Obtained Mark</span>
                        @if ($answer->exam_status == 2)
                            <span class="status-badge status-completed">
                                <span class="material-symbols-outlined">check_circle</span>
                                Completed
                            </span>
                        @else
                            <span class="status-badge status-pending">
                                <span class="material-symbols-outlined">check_circle</span>
                                Not Submitted
                            </span>
                        @endif

                    </div>
                </a>
            @endforeach

        </div>

    </div>
@endsection
