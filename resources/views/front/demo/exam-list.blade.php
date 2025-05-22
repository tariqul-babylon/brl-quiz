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
            margin-bottom: 15px;
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
        .exam-card.exam-card-draft{
            /* //hex code background color */
            background: #f1f2f6;
        }
        .exam-card.exam-card-published{
            background: #d1fae5;
        }
        .exam-card.exam-card-closed{
            background: #fee2e2;
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
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
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
            gap: 8px;
            flex-wrap: wrap;
           
        }

        .btn-custom {
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
            outline: none;
            }

        .btn-custom:hover {
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
      
        .btn-close-exam {
            /* hex code background  danger type color */
            background: #ff4757;

            color: white;
        }

        .btn-copy-exam-link{         
            background: var(--primary);
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
        .material-symbols-outlined{
            font-size: 16px;
        }
    </style>
@endpush

@section('content')
        <div class="container mt-4">
            <div class="header">
                <h3>Exam List</h3>
                <div class="d-flex gap-2 align-items-center flex-wrap">
                    <div class="search-filter">
                        <input type="text" placeholder="Search exams...">
                    </div>
    
                    <button class="btn-custom btn-show">
                        <span class="material-symbols-outlined">add</span> Add Exam
                    </button>
                </div>
            </div>

            <div class="exam-list">

                @foreach (range(1, 10) as $item)
                    <div class="exam-card @if(rand(1,3) == 1) exam-card-published @elseif(rand(1,3) == 2) exam-card-closed @else exam-card-upcoming @endif">
                        <div class="exam-header">
                            <div class="exam-info">
                                <h3 class="exam-title m-0 lh-1">
                                    @if (rand(1, 3) == 1)
                                        <span class="exam-status status-published">Published</span>
                                    @elseif (rand(1, 3) == 2)
                                        <span class="exam-status status-closed">Closed</span>
                                    @else
                                        <span class="exam-status status-draft">Draft</span>
                                    @endif
                                    @php
                                        $faker = Faker\Factory::create();
                                    @endphp
                                    {{ $faker->sentence(5) }}
                                </h3>
                            </div>
                            <div>
                                <div class=" m-0 lh-1" style="font-size: 16px;">
                                    <span class="text-muted">Exam Code#</span> <b class="">1EXA02</b>
                                </div>
                            </div>
                        </div>

                        <div class="exam-details">
                            <div class="detail-group">
                                <span><span class="material-symbols-outlined">event</span> Total 30 Questions</span>
                                <span><span class="material-symbols-outlined">access_time</span> Duration: 02:00:00</span>
                            </div>
                            <div class="detail-group">
                                <span><span class="material-symbols-outlined">check_circle</span> Total Mark : 10</span>
                                <span><span class="material-symbols-outlined">school</span> Negative Mark : -0.25</span>
                            </div>
                            <div class="detail-group">
                                <span><span class="material-symbols-outlined">people</span> Only Logged in Students</span>
                                <span><span class="material-symbols-outlined">shuffle</span> Question and Options Randomized</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between flex-wrap align-items-start">
                            <div class="exam-actions">
                                <button class="btn-custom btn-add">
                                    <span class="material-symbols-outlined">add</span> Add Question
                                </button>
                                <button class="btn-custom btn-edit">
                                    <span class="material-symbols-outlined">edit</span> Edit
                                </button>
                                <button class="btn-custom btn-delete">
                                    <span class="material-symbols-outlined">delete</span> Delete
                                </button>
                                <button class="btn-custom btn-publish">
                                    <span class="material-symbols-outlined">visibility</span> View Details
                                </button>
                                <button class="btn-custom btn-result">
                                    <span class="material-symbols-outlined">assessment</span> Result
                                </button>
                                <button class="btn-custom btn-show">
                                    <span class="material-symbols-outlined">publish</span> Publish Exam
                                </button>
                                <button class="btn-custom btn-close-exam">
                                    <span class="material-symbols-outlined">close</span> Close Exam
                                </button>
                                </div>
                            <div>
                                <button class="btn-custom btn-copy-exam-link" data-exam-link="{{ route('front.exam', ['exam_code' => '1EXA'.rand(100, 999)]) }}">
                                    <span class="material-symbols-outlined">content_copy</span> Copy Exam Link
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    @endsection

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const copyExamLinkButtons = document.querySelectorAll('.btn-copy-exam-link');
                copyExamLinkButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const examLink = this.getAttribute('data-exam-link');
                        navigator.clipboard.writeText(examLink);
                        alert('Exam link copied to clipboard: ' + examLink);
                    });
                });
            });
        </script>
    @endpush