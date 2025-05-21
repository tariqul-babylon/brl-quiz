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
                        <td class="text-end">
                            <div class="dropdown action">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action <span class="material-symbols-outlined">expand_more</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('exams.show', $exam->id) }}">
                                            <span class="material-symbols-outlined">visibility</span> View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('exams.edit', $exam->id) }}">
                                            <span class="material-symbols-outlined">edit</span> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('exam_questions.index', $exam->id) }}">
                                            <span class="material-symbols-outlined">quiz</span> Questions Add
                                        </a>
                                    </li>

                                    @if(!$exam->exam_link)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('exam.create-link', $exam->id) }}">
                                                <span class="material-symbols-outlined">link</span> Create Exam Link
                                            </a>
                                        </li>
                                    @endif

                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addTeacherModal" data-exam-id="{{ $exam->id }}">
                                            <span class="material-symbols-outlined">person_add</span> Add Teacher
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addStudentModal" data-exam-id="{{ $exam->id }}">
                                            <span class="material-symbols-outlined">person_add_alt</span> Add Student
                                        </a>
                                    </li>

                                    <li>
                                        <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete this exam?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" style="border: none; background: none;">
                                                <span class="material-symbols-outlined">delete</span> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('exam.assign-teacher') }}" id="assignTeacherForm">
                                        @csrf
                                        <!-- Removed hidden exam_id input -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Assign Teacher</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3 d-flex flex-column">
                                                    <label for="teacherSelect" class="form-label">Select Teacher:</label>
                                                    <select id="teacherSelect" name="user_id" class="form-control"></select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary">Assign</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Add Student Modal -->
                            <div class="modal fade" id="addStudentModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('exam.assign-student') }}" id="assignStudentForm">
                                        @csrf
                                        <!-- Removed hidden exam_id input -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Assign Student</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3 d-flex flex-column">
                                                    <label for="studentSelect" class="form-label">Select Student:</label>
                                                    <select id="studentSelect" name="user_id" class="form-control"></select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary">Assign</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

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
