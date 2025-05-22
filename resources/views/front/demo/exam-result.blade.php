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
        <div class="header">
            <h1 class="page-title">
                <span class="material-symbols-outlined">assignment</span>
                Student Results
            </h1>
            <div class="search-filter">
                <input type="text" placeholder="Search students...">
                <button class="btn">
                    <span class="material-symbols-outlined">filter_alt</span>
                </button>
            </div>
        </div>
        <div class="result-cards">

            @foreach (range(1, 10) as $item)
                <!-- Result Card 1 -->
                <a href="" class="result-card text-decoration-none">
                    <div class="student-info">
                        <h3 class="student-name">
                            <span class="material-symbols-outlined">person</span>
                            Sarah Johnson
                        </h3>
                        <div class="student-meta">
                            <span class="meta-item">
                                <span class="material-symbols-outlined">badge</span>
                                ID: S2023001
                            </span>
                            <span class="meta-item">
                                <span class="material-symbols-outlined">phone</span>
                                +1 555-1234
                            </span>
                        </div>
                        <div class="student-meta">
                            <span class="meta-item">
                                <span class="material-symbols-outlined">schedule</span>
                                10:00:15
                            </span>
                        </div>
                        <div class="student-meta">
                            <span class="text-decoration-none text-primary">Click to View Details</span>
                        </div>
                    </div>

                    <div class="exam-stats">
                        <div class="stat-item">
                            <span class="stat-label">Correct</span>
                            <span class="stat-value stat-correct">28</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Incorrect</span>
                            <span class="stat-value stat-incorrect">5</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Unanswered</span>
                            <span class="stat-value stat-neutral">2</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Full Mark</span>
                            <span class="stat-value">35.00</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Obtained</span>
                            <span class="stat-value">31.25</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Penalty</span>
                            <span class="stat-value stat-incorrect">-2.50</span>
                        </div>
                    </div>

                    <div class="result-summary">
                        <span class="total-mark">28.75</span>
                        <span class="mark-details">Final Obtained Mark</span>
                        @if (rand(1, 2) == 1)
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
