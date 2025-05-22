@extends('front.layouts.app')
@section('content')
<div class="container " >
<div class="page-title">
        <div class="d-flex justify-content-between align-items-end">
            <h1 class="title">Exams List</h1>
            <a href="{{ route('exams.create') }}" class="btn btn-primary">
                <span class="material-symbols-outlined">add</span>
                New
            </a>
        </div>
    </div>

    <div class="page-content">
        <div class="table-responsive bg-white">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Exam Code</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Full Mark</th>
                    <th>Duration (Hr)</th>
                    <th>Exam Status</th>
                    <th>Logo</th>
                    <th>Flags</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($exams as $key => $exam)
                    <tr>
                        <td>{{ $exams->firstItem() + $loop->index }}</td>
                        <td>{{ $exam->title }}</td>
                        <td>{{ $exam->exam_code }}</td>
                        <td>{{ \Carbon\Carbon::parse($exam->exam_start_time)->format('d-m-Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($exam->exam_end_time)->format('d-m-Y H:i') }}</td>
                        <td>{{ $exam->full_mark }}</td>
                        <td>{{ $exam->duration }}</td>
                        <td>
                            @if($exam->exam_status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @if($exam->logo)
                                <img src="{{ asset('storage/' . $exam->logo) }}" alt="Logo" style="height: 40px;">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @php
                                $flags = [
                                    'is_bluer', 'is_timer', 'is_date_enabled',
                                    'user_result_view', 'user_answer_view',
                                    'is_question_random', 'is_option_random',
                                    'is_sign_in_required', 'is_specific_student'
                                ];
                            @endphp

                            @foreach($flags as $flag)
                                @if($exam->$flag)
                                    <span class="badge bg-info text-dark me-1" title="{{ ucwords(str_replace('_', ' ', $flag)) }}">
                                            {{ ucwords(str_replace('_', ' ', $flag)) }}
                                        </span>
                                @endif
                            @endforeach
                        </td>
                        <td class="text-end d-flex flex-wrap gap-2 justify-content-end">

                            <a href="{{ route('exams.show', $exam->id) }}" class="btn btn-sm btn-primary">
                                <span class="material-symbols-outlined">visibility</span> View
                            </a>

                            <a href="{{ route('exams.edit', $exam->id) }}" class="btn btn-sm btn-warning">
                                <span class="material-symbols-outlined">edit</span> Edit
                            </a>

                            <a href="{{ route('front.exam_questions.index', $exam->id) }}" class="btn btn-sm btn-info">
                                <span class="material-symbols-outlined">quiz</span> Questions Add
                            </a>

                            <a href="{{ route('front.exam.results', $exam->id) }}" class="btn btn-sm btn-info" title="View Results">
                                <span class="material-symbols-outlined">quiz</span> Result
                            </a>

                        @if(!$exam->exam_link)
                                <a href="{{ route('exam.create-link', $exam->id) }}" class="btn btn-sm btn-secondary">
                                    <span class="material-symbols-outlined">link</span> Create Exam Link
                                </a>
                            @endif

{{--                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addTeacherModal" data-exam-id="{{ $exam->id }}">--}}
{{--                                <span class="material-symbols-outlined">person_add</span> Add Teacher--}}
{{--                            </button>--}}

{{--                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal" data-exam-id="{{ $exam->id }}">--}}
{{--                                <span class="material-symbols-outlined">person_add_alt</span> Add Student--}}
{{--                            </button>--}}

                            <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete this exam?');" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <span class="material-symbols-outlined">delete</span> Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $exams->links() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function initTomSelect(selector, userType, examId) {
            const element = document.querySelector(selector);

            // Destroy if already initialized
            if (element.tomselect) {
                element.tomselect.destroy();
            }

            new TomSelect(selector, {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                loadThrottle: 300,
                maxOptions: 10,
                minQueryLength: 3,
                render: {
                    option: function(item) {
                        const imgSrc = item.image ?? '{{ asset('img/logo.png') }}';
                        const disabledBadge = item.disabled
                            ? `<span class="badge bg-secondary ms-auto">Already Exist</span>`
                            : '';

                        return `
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-start">
                                    <img src="${imgSrc}" class="rounded-circle me-2" width="40" height="40" />
                                    <div>
                                        <div class="fw-bold">${item.name}</div>
                                        <small>${item.email}</small>
                                    </div>
                                </div>
                                ${disabledBadge}
                            </div>
                        `;
                    }
                },
                load: function(query, callback) {
                    const url = `/dashboard/users/search/ajax?q=${encodeURIComponent(query)}&type=${userType}&exam_id=${examId}`;
                    fetch(url)
                        .then(res => res.json())
                        .then(data => callback(data))
                        .catch(() => callback([]));
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-bs-target="#addTeacherModal"]').forEach(btn => {
                btn.addEventListener('click', function () {
                    const examId = this.dataset.examId;
                    const form = document.getElementById('assignTeacherForm');
                    const baseUrl = "{{ route('exam.assign-teacher') }}";
                    form.action = `${baseUrl}?exam_id=${examId}`;

                    initTomSelect('#teacherSelect', 1, examId); // Pass examId here
                });
            });

            document.querySelectorAll('[data-bs-target="#addStudentModal"]').forEach(btn => {
                btn.addEventListener('click', function () {
                    const examId = this.dataset.examId;
                    const form = document.getElementById('assignStudentForm');
                    const baseUrl = "{{ route('exam.assign-student') }}";
                    form.action = `${baseUrl}?exam_id=${examId}`;

                    initTomSelect('#studentSelect', 2, examId); // Pass examId here
                });
            });
        });
    </script>
@endsection
