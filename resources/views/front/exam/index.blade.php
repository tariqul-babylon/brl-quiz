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

        .exam-card.exam-card-draft {
            background: #f1f2f6;
        }

        .exam-card.exam-card-published {
            background: #d1fae5;
        }

        .exam-card.exam-card-closed {
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

        .status-draft {
            background: #f1f1f1;
            color: #666;
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
            text-decoration: none;
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
            background: #ff4757;
            color: white;
        }

        .btn-copy-exam-link {
            background: var(--primary);
            color: white;
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

        .material-symbols-outlined {
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
                <a href="{{ route('exams.create') }}" class="btn-custom btn-show">
                    <span class="material-symbols-outlined">add</span> Add Exam
                </a>
            </div>
        </div>

        <div class="exam-list">
            @forelse ($exams as $exam)
                {{-- @dump($exam) --}}
                @php
                    // Map status to class and label
                    $statusClass = match ($exam->exam_status) {
                        2 => 'exam-card-published',
                        3 => 'exam-card-closed',
                        1 => 'exam-card-draft',
                        0 => 'exam-card-draft',
                    };
                    $statusMap = [
                        1 => 'Draft',
                        2 => 'Published',
                        3 => 'Completed',
                    ];

                    $statusLabel = ucfirst($statusMap[$exam->exam_status] ?? 'Draft');
                    $statusBadge = match ($exam->exam_status) {
                        2 => 'status-published',
                        3 => 'status-closed',
                        1 => 'status-draft',
                        0 => 'status-draft',
                    };
                    $fullMark = 0;
                    if ($exam->questions) {
                        $fullMark = count($exam->questions) * $exam->mark_per_question;
                    }
                @endphp
                <div class="exam-card {{ $statusClass }}">
                    <div class="exam-header">
                        <div class="exam-info">
                            <h3 class="exam-title m-0 lh-1">
                                <span class="exam-status {{ $statusBadge }}">{{ $statusLabel }}</span>
                                {{ $exam->title }}
                            </h3>
                            @if ($exam->description)
                                <div class="exam-tagline">{{ $exam->description }}</div>
                            @endif
                        </div>
                        <div>
                            <div class=" m-0 lh-1" style="font-size: 16px;">
                                <span class="text-muted">Exam Code#</span> <b>{{ $exam->exam_code }}</b>
                            </div>
                        </div>
                    </div>

                    <div class="exam-details">
                        <div class="detail-group">
                            <span><span class="material-symbols-outlined">event</span> Total
                                {{ $exam->questions_count ?? '0' }} Questions</span>
                            <span><span class="material-symbols-outlined">access_time</span> Duration:
                                {{ $exam->duration ?? '00:00:00' }}</span>
                        </div>
                        <div class="detail-group">
                            <span><span class="material-symbols-outlined">check_circle</span> Total Mark :
                                {{ $fullMark ?? '-' }}</span>
                            <span><span class="material-symbols-outlined">school</span> Negative Mark :
                                {{ $exam->negative_mark ?? '-' }}</span>
                        </div>
                        <div class="detail-group">
                            @if ($exam->is_sign_in_required)
                                <span><span class="material-symbols-outlined">people</span> Only Logged in Students</span>
                            @endif
                            @if ($exam->is_question_random && $exam->is_option_random)
                                <span><span class="material-symbols-outlined">shuffle</span> Question and Options
                                    Randomized</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap align-items-start">
                        <div class="exam-actions">
                            <a href="{{ route('exam_questions.index', $exam->id) }}" class="btn-custom btn-add">
                                <span class="material-symbols-outlined">add</span> Add Question
                            </a>
                            <a href="{{ route('exams.edit', $exam->id) }}" class="btn-custom btn-edit">
                                <span class="material-symbols-outlined">edit</span> Edit
                            </a>
                            <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-custom btn-delete"
                                    onclick="return confirm('Are you sure?')">
                                    <span class="material-symbols-outlined">delete</span> Delete
                                </button>
                            </form>
                            <a href="{{ route('exams.show', $exam->id) }}" class="btn-custom btn-show">
                                <span class="material-symbols-outlined">visibility</span> View Details
                            </a>
                            <a href="{{ route('front.exam.results', $exam->id) }}" class="btn-custom btn-result">
                                <span class="material-symbols-outlined">assessment</span> Result
                            </a>

                            @if ($exam->exam_status == 1)
                                <button class="btn-custom btn-show btn-update-status" data-exam-id="{{ $exam->id }}"
                                    data-status="2" data-action="publish">
                                    <span class="material-symbols-outlined">publish</span> Publish Exam
                                </button>
                            @endif

                            @if ($exam->exam_status == 2)
                                <button class="btn-custom btn-close-exam btn-update-status"
                                    data-exam-id="{{ $exam->id }}" data-status="3" data-action="complete">
                                    <span class="material-symbols-outlined">close</span> Complete Exam
                                </button>
                            @endif
                        </div>
                        <div>
                            <button class="btn-custom btn-copy-exam-link"
                                data-exam-link="{{ route('front.exam', ['exam_code' => $exam->exam_code]) }}">
                                <span class="material-symbols-outlined">content_copy</span> Copy Exam Link
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">No exams found.</div>
            @endforelse
        </div>
        <div class="mt-3">
            {{ $exams->links() }}
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyExamLinkButtons = document.querySelectorAll('.btn-copy-exam-link');
            copyExamLinkButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const examLink = this.getAttribute('data-exam-link');
                    navigator.clipboard.writeText(examLink);
                    alert('Exam link copied to clipboard: ' + examLink);
                });
            });

            document.querySelectorAll('.btn-update-status').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const examId = this.getAttribute('data-exam-id');
                    const status = this.getAttribute('data-status');
                    const action = this.getAttribute('data-action');
                    if (!confirm('Are you sure you want to ' + action + ' this exam?')) return;

                    fetch(`/exam/${examId}/update-status`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                status: status
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.code === 200) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert(data.message || 'Failed to update status');
                            }
                        })
                        .catch(err => {
                            alert('Error updating status');
                        });
                });
            });
        });
    </script>
@endpush
