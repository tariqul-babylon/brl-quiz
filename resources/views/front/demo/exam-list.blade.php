@extends('front.layouts.app')
@push('css')
    <style>
        :root {
            --primary: #4a6bff;
            --danger: #ff4757;
            --warning: #ffa502;
            --success: #2ed573;
            --dark: #2f3542;
            --light: #f1f2f6;
            --published: #d1fae5;
            --closed: #fee2e2;
            --upcoming: #dbeafe;
        }


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header h1 {
            color: var(--dark);
        }

        .search-filter {
            display: flex;
            gap: 10px;
        }

        .search-filter input {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            min-width: 250px;
        }

        .exam-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .exam-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            transition: all 0.3s;
        }

        .exam-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .exam-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
        }

        .exam-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .exam-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
        }

        .exam-tagline {
            color: #666;
            font-size: 0.9rem;
        }

        .exam-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status-published {
            background: var(--published);
            color: #065f46;
        }

        .status-closed {
            background: var(--closed);
            color: #b91c1c;
        }

        .status-upcoming {
            background: var(--upcoming);
            color: #1e40af;
        }

        .exam-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            font-size: 0.85rem;
            color: #555;
        }

        .detail-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .detail-group span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .exam-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-add {
            background: var(--warning);
            color: white;
        }

        .btn-edit {
            background: var(--primary);
            color: white;
        }

        .btn-delete {
            background: var(--danger);
            color: white;
        }

        .btn-show {
            background: var(--success);
            color: white;
        }

        .btn-result {
            background: #8e44ad;
            color: white;
        }

        .status-draft {
            background: #f1f1f1;
            color: #666;
        }

        @media (max-width: 600px) {
            .exam-header {
                flex-direction: column;
            }

            .search-filter {
                width: 100%;
            }

            .search-filter input {
                min-width: unset;
                flex-grow: 1;
            }
        }
    </style>
@endpush

@section('content')

        <div class="container mt-4">
            <div class="header">
                <h3>Exam List</h3>
                <div class="search-filter">
                    <input type="text" placeholder="Search exams...">
                </div>
            </div>

            <div class="exam-list">

                @foreach (range(1, 10) as $item)
                    <div class="exam-card">
                        <div class="exam-header">
                            <div class="exam-info">
                                <h3 class="exam-title m-0 lh-1">Physics Intermediate

                                    @if (rand(1, 3) == 1)
                                        <span class="exam-status status-published">Published</span>
                                    @elseif (rand(1, 3) == 2)
                                        <span class="exam-status status-closed">Closed</span>
                                    @else
                                        <span class="exam-status status-draft">Draft</span>
                                    @endif
                                </h3>
                            </div>
                            <div>
                                <h3 class="exam-title text-secondary m-0 lh-1">Exam Code# 1EXA02</h3>
                            </div>
                        </div>

                        <div class="exam-details">
                            <div class="detail-group">
                                <span><i class="far fa-calendar-alt"></i> Total 30 Questions</span>
                                <span><i class="far fa-clock"></i> Duration: 02:00:00</span>
                            </div>
                            <div class="detail-group">
                                <span><i class="fas fa-check-circle"></i> Total Mark : 10</span>
                                <span><i class="fas fa-user-graduate"></i> Negative Mark : -0.25</span>
                            </div>
                            <div class="detail-group">
                                <span><i class="fas fa-random"></i> Only Logged in Students</span>
                                <span><i class="fas fa-eye-slash"></i> Question and Options Randomized</span>
                            </div>
                        </div>

                        <div class="exam-actions">
                            <button class="btn btn-add">
                                <i class="fas fa-plus"></i> Add Question
                            </button>
                            <button class="btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                            <button class="btn btn-show">
                                <i class="fas fa-eye"></i> Show
                            </button>


                        </div>


                    </div>
                @endforeach

            </div>
        </div>
    @endsection
